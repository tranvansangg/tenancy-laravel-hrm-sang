<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EmployeePayrollController extends Controller
{
    public function index(Request $request)
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            abort(403, 'Không tìm thấy thông tin nhân viên');
        }

        $month = $request->get('month', Carbon::now()->month);
        $year  = $request->get('year', Carbon::now()->year);

        // Lấy bảng lương của nhân viên theo tháng/năm
        $payroll = Payroll::where('employee_id', $employee->id)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        return view('employee.payrolls.index', compact('employee', 'payroll', 'month', 'year'));
    }
}
