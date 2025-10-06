<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\InsuranceRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LeavesController extends Controller
{
    // Danh sách đơn nghỉ phép của nhân viên
    public function index()
    {
        $employee = Auth::user()->employee;
        if (!$employee) {
            return back()->with('error','Không tìm thấy thông tin nhân viên.');
        }

        $leaves = Leave::where('employee_id', $employee->id)
                       ->orderBy('created_at','desc')
                       ->paginate(10);

        return view('employee.leaves.index', compact('leaves','employee'));
    }

    // Form tạo đơn nghỉ phép
  // Controller Employee\LeavesController.php
public function create()
{
    $employee = Auth::user()->employee;
    if (!$employee) {
        return back()->with('error','Không tìm thấy thông tin nhân viên.');
    }

    $leaveTypes = [];

    // Nghỉ phép năm
    $remainingAnnualLeave = $this->getRemainingAnnualLeave($employee);
    if ($remainingAnnualLeave > 0) {
        $leaveTypes[] = 'annual';
    }

    // Kiểm tra BHXH
    $hasInsurance = InsuranceRecord::where('employee_id', $employee->id)
        ->where('status', 'active')
        ->whereDate('participation_date', '<=', now())
        ->exists();

    $sickMaxDays = 0;
    if ($hasInsurance) {
        $leaveTypes[] = 'sick';
        $leaveTypes[] = 'maternity';
        $sickMaxDays = $this->getRemainingSickLeaveDays($employee); // số ngày nghỉ ốm còn lại
    }

    $leaveTypes[] = 'unpaid';

    return view('employee.leaves.create', compact('leaveTypes','remainingAnnualLeave','employee','sickMaxDays'));
}   

    // Lưu đơn nghỉ phép
    public function store(Request $request)
    {
        $employee = Auth::user()->employee;
        if (!$employee) {
            return back()->with('error','Không tìm thấy thông tin nhân viên.');
        }

        $days = Carbon::parse($request->start_date)->diffInDays(Carbon::parse($request->end_date)) + 1;
        $fileRequired = false;
        $is_paid = false;

        // Kiểm tra có BHXH không
        $hasInsurance = InsuranceRecord::where('employee_id', $employee->id)
            ->where('status', 'active')
            ->whereDate('participation_date', '<=', now())
            ->exists();

        switch($request->leave_type){
            case 'annual':
                $remainingAnnualLeave = $this->getRemainingAnnualLeave($employee);
                if($remainingAnnualLeave <= 0){
                    return back()->with('error','Bạn đã hết số ngày phép còn lại.');
                }
                $days = min($days, $remainingAnnualLeave);
                $is_paid = true;
                break;

            case 'unpaid':
                $is_paid = false;
                if($days > 7){
                    $fileRequired = true;
                }
                break;

            case 'sick':
                if(!$hasInsurance){
                    return back()->with('error','Chỉ nhân viên tham gia BHXH mới được nghỉ ốm.');
                }
                $days = $this->getRemainingSickLeaveDays($employee);
                $is_paid = false;
                $fileRequired = true;
                break;

            case 'maternity':
                if(!$hasInsurance){
                    return back()->with('error','Chỉ nhân viên tham gia BHXH mới được nghỉ thai sản.');
                }
                $days = 180;
                $is_paid = false;
                $fileRequired = true;
                break;
        }

        // Validate file
        $rules = [
            'document' => $fileRequired
                ? 'required|file|mimes:jpeg,png,jpg,pdf|max:2048'
                : 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048'
        ];
        $request->validate($rules);

        $documentPath = $request->hasFile('document')
            ? $request->file('document')->store('leave_documents','public')
            : null;

        Leave::create([
            'employee_id'=>$employee->id,
            'leave_type'=>$request->leave_type,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'days'=>$days,
            'status'=>'pending',
            'is_paid'=>$is_paid,
            'reason'=>$request->reason,
            'document'=>$documentPath
        ]);

        return redirect()->route('employee.leaves.index')
                         ->with('success','Đơn nghỉ phép đã được gửi, chờ duyệt.');
    }

    // Tính số ngày nghỉ phép năm
   // Tính số ngày nghỉ phép năm dựa theo ngày làm việc thực tế
protected function getRemainingAnnualLeave($employee)
{
    $year = Carbon::now()->year;

    // Ngày bắt đầu làm (nếu chưa có thì mặc định đầu năm)
    $startWork = Carbon::parse($employee->start_work_date ?? Carbon::now()->startOfYear());

    // Tổng số ngày từ khi đi làm đến hiện tại trong năm
    $totalDaysWorked = Carbon::now()->diffInDays($startWork) + 1;

    // Trừ đi tất cả số ngày nghỉ (ốm, thai sản, không lương)
    $daysOff = Leave::where('employee_id', $employee->id)
        ->whereIn('leave_type', ['sick', 'maternity', 'unpaid'])
        ->where('status', 'approved')
        ->whereYear('start_date', $year)
        ->sum('days');

    $actualWorkedDays = max($totalDaysWorked - $daysOff, 0);

    // Cứ 26 ngày làm việc thực tế = 1 ngày phép năm
    $earnedLeaveDays = floor($actualWorkedDays / 26);

    // Số ngày phép đã dùng trong năm
    $usedLeave = Leave::where('employee_id', $employee->id)
        ->where('leave_type', 'annual')
        ->where('is_paid', true)
        ->where('status', 'approved')
        ->whereYear('start_date', $year)
        ->sum('days');

    // Phép còn lại
    return max($earnedLeaveDays - $usedLeave, 0);
}

    // Tính số ngày nghỉ ốm (dựa vào BHXH tham gia, không còn dùng employee->bhxh_join_date)
    protected function getRemainingSickLeaveDays($employee)
    {
        $max = 30; // Default cho tất cả vì không còn chia theo số năm BHXH
        $used = Leave::where('employee_id',$employee->id)
                    ->where('leave_type','sick')
                    ->where('status','approved')
                    ->whereYear('start_date',Carbon::now()->year)
                    ->sum('days');

        return max($max - $used,0);
    }

    // Xem chi tiết
    public function show($id)
    {
        $employee = Auth::user()->employee;
        if (!$employee) {
            return back()->with('error','Không tìm thấy thông tin nhân viên.');
        }

        $leave = Leave::where('id', $id)->where('employee_id', $employee->id)->first();
        if(!$leave){
            return back()->with('error','Đơn nghỉ phép không tồn tại.');
        }

        return view('employee.leaves.show', compact('leave','employee'));
    }
}
