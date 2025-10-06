<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\HolidayRequest;
use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidayRequestController extends Controller
{
    // Danh sách request của nhân viên
    public function index()
    {
        $requests = HolidayRequest::with(['holiday', 'department'])
            ->where('employee_id', Auth::user()->employee->id)
            ->latest()
            ->get();

        return view('employee.holiday_requests.index', compact('requests'));
    }

    // Form đăng ký
    public function create()
    {
        $holidays = Holiday::orderBy('date', 'asc')->get();
        return view('employee.holiday_requests.create', compact('holidays'));
    }

    // Lưu đăng ký
    public function store(Request $request)
    {
        $request->validate([
            'holiday_id' => 'required|exists:holidays,id',
            'reason' => 'nullable|string|max:255',
        ]);

        $employee = Auth::user()->employee;

        HolidayRequest::create([
            'employee_id' => $employee->id,
            'department_id' => $employee->department_id,
            'holiday_id' => $request->holiday_id,
            'reason' => $request->reason,
            'status' => 'pending_manager',
        ]);

        return redirect()->route('employee.holiday_requests.index')
            ->with('success', 'Gửi đăng ký thành công, chờ trưởng phòng duyệt.');
    }
}
