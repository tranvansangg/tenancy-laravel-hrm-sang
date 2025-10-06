<?php

namespace App\Http\Controllers\Employee;

use App\Models\InsuranceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;    

class EmployeeInsuranceController extends Controller
{
    // Hiển thị danh sách bảo hiểm của nhân viên đang đăng nhập
    public function index()
    {
        $employee = Auth::user()->employee; // lấy thông tin nhân viên từ user
        if (!$employee) {
            return back()->with('error', 'Không tìm thấy thông tin nhân viên');
        }

        $records = InsuranceRecord::where('employee_id', $employee->id)->get();

        return view('employee.insurance.index', compact('records'));
    }
}
