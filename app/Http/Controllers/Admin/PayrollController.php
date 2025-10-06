<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payroll;
use Carbon\Carbon;

class PayrollController extends Controller
{
    /**
     * Hiển thị bảng lương của tất cả nhân viên
     */
    public function index(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year  = $request->get('year', Carbon::now()->year);

        $payrolls = Payroll::with(['employee.position'])
            ->where('month', $month)
            ->where('year', $year)
            ->orderBy('employee_id', 'asc')
            ->paginate(50);

        return view('admin.payrolls.index', compact('payrolls', 'month', 'year'));
    }
}
