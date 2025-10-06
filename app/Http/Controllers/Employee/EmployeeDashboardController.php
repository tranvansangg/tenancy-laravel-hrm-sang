<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller; // ← bắt buộc phải import
use Illuminate\Support\Facades\Auth;
use App\Models\Leave;
use App\Models\BusinessTrip;


use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $employeeId = Auth::user()->employee->id;

        // Lấy các công tác đã được admin duyệt và chưa xem
        $notifications = BusinessTrip::where('employee_id', $employeeId)
                                     ->where('status', 'approved')
                                     ->latest()
                                     ->get();

        return view('employee.dashboard', compact('notifications'));
    }
}
