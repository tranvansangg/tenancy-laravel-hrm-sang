<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Allowance;
use App\Models\Bonus;
use App\Models\Deduction;
use App\Models\Leave;
use App\Models\OvertimeEmployee;
use App\Models\Holiday;
use App\Models\Payroll;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PayrollExport;
use Illuminate\Support\Facades\Auth;


class PayrollController extends Controller
{
    /**
     * Chỉ Trưởng phòng mới được quyền tính lương
     */
    public function generatePayroll(Request $request)
    {
        $user = auth()->user();
        $managerEmployee = $user->employee;

        if (
            !$managerEmployee ||
            !$managerEmployee->position ||
            $managerEmployee->position->name !== 'Trưởng phòng'
        ) {
            abort(403, 'Bạn không có quyền thực hiện tính lương');
        }

        $month = $request->month ?? now()->month;
        $year  = $request->year ?? now()->year;

        // Ngày submit sự kiện
        $eventDate = Carbon::now()->startOfDay();

        $employees = Employee::with('position')->get();

        foreach ($employees as $emp) {
            $payrollData = $this->calculatePayrollForEmployee($emp, $month, $year, $eventDate);

            Payroll::updateOrCreate(
                ['employee_id' => $emp->id, 'month' => $month, 'year' => $year],
                $payrollData
            );
        }

        return back()->with(
            'success',
            "✅ Đã tính lương từ ngày vào công ty đến ngày {$eventDate->format('Y-m-d')} cho toàn công ty"
        );
    }

    /**
     * Tính lương cho 1 nhân viên
     */
    private function calculatePayrollForEmployee($employee, $month, $year, $eventDate)
    {
        // Ngày bắt đầu: từ ngày vào công ty hoặc đầu tháng
        $startWork  = Carbon::parse($employee->start_work_date)->startOfDay();
        $monthStart = Carbon::create($year, $month, 1)->startOfDay();
        $startDate  = $startWork->greaterThan($monthStart) ? $startWork : $monthStart;

        // Ngày kết thúc: ngày sự kiện hoặc cuối tháng
        $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth()->startOfDay();
        $endDate    = $eventDate->greaterThan($endOfMonth) ? $endOfMonth : $eventDate->startOfDay();

        $dailySalary = $employee->position->daily_salary ?? 0;

        // Nếu chưa đủ điều kiện
        if ($startDate->greaterThan($endDate)) {
            return $this->emptyPayroll($startDate, $endDate);
        }

        // ===== Các khoản cộng/trừ định kỳ =====
        $allowances = $employee->allowances()->where('month', $month)->sum('amount');
        $bonuses    = $employee->bonuses()->where('month', $month)->sum('amount');
        $deductions = $employee->deductions()->where('month', $month)->sum('amount');

        // ===== Ngày nghỉ phép trong khoảng =====
        $leavesOverlap = $employee->leaves()
            ->where('status', 'approved')
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate])
                  ->orWhere(function ($q2) use ($startDate, $endDate) {
                      $q2->where('start_date', '<', $startDate)
                         ->where('end_date', '>', $endDate);
                  });
            })->get();

        // ===== Ngày công chuẩn (trừ CN) =====
        $workDays = $this->countWorkingDays($startDate, $endDate);

        // ===== Điều chỉnh theo nghỉ phép =====
        $paidLeavesDays   = 0;
        $unpaidLeavesDays = 0;

foreach ($leavesOverlap as $lv) {
    $lvStart = Carbon::parse($lv->start_date)->startOfDay();
    $lvEnd   = Carbon::parse($lv->end_date)->startOfDay();
    $ovStart = $lvStart->greaterThan($startDate) ? $lvStart : $startDate;
    $ovEnd   = $lvEnd->lessThan($endDate) ? $lvEnd : $endDate;

    $lvPeriod = CarbonPeriod::create($ovStart, $ovEnd);
    foreach ($lvPeriod as $lvDay) {
        if ($lvDay->dayOfWeek == Carbon::SUNDAY) continue;

        if ($lv->is_paid) {
            $paidLeavesDays++;
            // nghỉ có lương => vẫn tính công
        } else {
            $unpaidLeavesDays++;
            $workDays--; // nghỉ không lương => không tính công
            // ❌ bỏ dòng này đi: $deductions += $dailySalary;
        }
    }
}

        // ===== Tăng ca (OT) =====
        $overtimePay = $this->calculateOvertime($employee, $month, $year, $dailySalary);

        // ===== Bảo hiểm =====
        $insurance = 0;
        $hasInsurance = \App\Models\InsuranceRecord::where('employee_id', $employee->id)
            ->where('status', 'active')
            ->exists();

        if ($hasInsurance) {
            $insurance = ($dailySalary * $workDays) * 0.105;
        }

        // ===== Tổng kết =====
        $baseSalary = $dailySalary * $workDays;
        $netSalary  = $baseSalary + $allowances + $bonuses + $overtimePay - $deductions - $insurance;

        // ===== Lý do nghỉ =====
        $leaveReason = $this->formatLeaveReason($leavesOverlap, $startDate, $endDate);

        return [
            'work_days'      => max($workDays, 0),
            'paid_leaves'    => $paidLeavesDays,
            'unpaid_leaves'  => $unpaidLeavesDays,
            'base_salary'    => $baseSalary,
            'allowance'      => $allowances,
            'bonus'          => $bonuses,
            'overtime'       => $overtimePay,
            'deduction'      => $deductions,
            'insurance'      => $insurance,
            'net_salary'     => max($netSalary, 0),
            'leave_reason'   => $leaveReason,
            'pay_start_date' => $startDate->format('Y-m-d'),
            'pay_end_date'   => $endDate->format('Y-m-d'),
        ];
    }

    /**
     * Trường hợp không có bảng lương
     */
    private function emptyPayroll($startDate, $endDate)
    {
        return [
            'work_days'      => 0,
            'paid_leaves'    => 0,
            'unpaid_leaves'  => 0,
            'base_salary'    => 0,
            'allowance'      => 0,
            'bonus'          => 0,
            'overtime'       => 0,
            'deduction'      => 0,
            'insurance'      => 0,
            'net_salary'     => 0,
            'leave_reason'   => null,
            'pay_start_date' => $startDate->format('Y-m-d'),
            'pay_end_date'   => $endDate->format('Y-m-d'),
        ];
    }

    /**
     * Đếm số ngày làm việc (trừ CN)
     */
    private function countWorkingDays(Carbon $from, Carbon $to): int
    {
        if ($from->greaterThan($to)) return 0;

        $period = CarbonPeriod::create($from, $to);
        $count  = 0;
        foreach ($period as $dt) {
            if ($dt->dayOfWeek != Carbon::SUNDAY) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * Tính tiền OT
     */
    private function calculateOvertime($employee, $month, $year, $dailySalary)
    {
        $overtimePay = 0;
        $otEmployees = OvertimeEmployee::with('overtime')
            ->where('employee_id', $employee->id)
            ->whereHas('overtime', function ($q) use ($month, $year) {
                $q->whereMonth('date', $month)
                  ->whereYear('date', $year)
                  ->where('status', 'approved');
            })->get();

        foreach ($otEmployees as $otEmp) {
            $ot = $otEmp->overtime;
            if (!$ot) continue;

            $start = strtotime($otEmp->start_time ?? $ot->start_time);
            $end   = strtotime($otEmp->end_time ?? $ot->end_time);
            $hours = max(0, ($end - $start) / 3600);

            $date      = $ot->date;
            $isHoliday = Holiday::where('date', $date)->exists();
            $dayOfWeek = date('N', strtotime($date));

            if ($isHoliday) {
                $rate = 3;
            } elseif ($dayOfWeek == 6) {
                $rate = 2;
            } elseif ($dayOfWeek == 7) {
                $rate = 3;
            } else {
                $rate = 1.5;
            }

            $overtimePay += ($dailySalary / 8) * $hours * $rate;
        }
        return $overtimePay;
    }

    /**
     * Format lý do nghỉ
     */
    private function formatLeaveReason($leaves, $startDate, $endDate)
    {
        if ($leaves->count() == 0) return null;

        $details = [];
        foreach ($leaves as $lv) {
            $lvStart = Carbon::parse($lv->start_date)->startOfDay();
            $lvEnd   = Carbon::parse($lv->end_date)->startOfDay();
            $ovStart = $lvStart->greaterThan($startDate) ? $lvStart : $startDate;
            $ovEnd   = $lvEnd->lessThan($endDate) ? $lvEnd : $endDate;
            if ($ovStart->greaterThan($ovEnd)) continue;

            $details[] = sprintf(
                "%s - %s (từ %s đến %s)",
                ucfirst($lv->leave_type ?? ($lv->type ?? 'Nghỉ')),
                $lv->reason ?? 'Không rõ',
                $ovStart->format('d/m/Y'),
                $ovEnd->format('d/m/Y')
            );
        }
        return implode("; ", $details);
    }

    /**
     * Xem bảng lương
     */
    public function indexx(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year  = $request->get('year', Carbon::now()->year);

        $payrolls = Payroll::with('employee.position')
            ->where('month', $month)
            ->where('year', $year)
            ->paginate(50);

        return view('manager.payrolls.indexx', compact('payrolls', 'month', 'year'));
    }

      public function mypayroll()
    {
        $user = Auth::user();
        $employee = $user->employee;

        // Kiểm tra quyền: chỉ trưởng phòng mới được xem
        if (!$employee || !$employee->position || $employee->position->name !== 'Trưởng phòng') {
            abort(403, 'Bạn không có quyền truy cập bảng lương này.');
        }

        // Lấy danh sách bảng lương theo tháng của chính trưởng phòng
        $payrolls = Payroll::where('employee_id', $employee->id)
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('manager.payrolls.mypayroll', compact('employee', 'payrolls'));
    }

    /**
     * Xuất Excel
     */
    public function export(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year  = $request->get('year', Carbon::now()->year);

        return Excel::download(new PayrollExport($month, $year), "payroll_{$month}_{$year}.xlsx");
    }
}
