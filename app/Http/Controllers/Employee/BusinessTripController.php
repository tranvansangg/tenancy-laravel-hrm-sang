<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\BusinessTrip;

class BusinessTripController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;

        // Chỉ lấy công tác của nhân viên đang đăng nhập + đã được duyệt
        $businessTrips = BusinessTrip::where('employee_id', $employee->id)
            ->where('status', 'approved')
            ->latest()
            ->paginate(10);

        return view('employee.business_trips.index', compact('businessTrips'));
    }

 public function show($id)
    {
        $employeeId = Auth::user()->employee->id;

        // Chỉ lấy công tác của chính nhân viên và đã được admin duyệt
        $trip = BusinessTrip::where('id', $id)
                            ->where('employee_id', $employeeId)
                            ->where('status', 'approved')
                            ->firstOrFail();

        return view('employee.business_trips.show', compact('trip'));
    }
}
