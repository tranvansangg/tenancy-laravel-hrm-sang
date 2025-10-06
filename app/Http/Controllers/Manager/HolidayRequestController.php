<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use App\Models\HolidayRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidayRequestController extends Controller
{
    // Danh sách đơn trong phòng ban
    public function index()
    {
        $manager = Auth::user()->employee;

        if (!$manager || $manager->position?->name !== 'Trưởng phòng') {
            return back()->with('error', 'Bạn không phải là trưởng phòng.');
        }

        $requests = HolidayRequest::with(['holiday', 'employee'])
            ->where('department_id', $manager->department_id)
            ->latest()
            ->get();

        return view('manager.holiday_requests.index', compact('requests'));
    }

    // Form đăng ký làm ngày lễ
    public function create()
    {
        $holidays = Holiday::orderBy('date')->get();
        return view('manager.holiday_requests.create', compact('holidays'));
    }

    // Lưu đơn đăng ký
// Lưu đơn đăng ký
public function store(Request $request)
{
    $employee = Auth::user()->employee;

    $request->validate([
        'holiday_id' => 'required|exists:holidays,id',
        'reason'     => 'nullable|string|max:255',
    ]);

    // Kiểm tra nếu là trưởng phòng
    $status = $employee->position?->name === 'Trưởng phòng'
        ? 'pending_admin'   // bỏ qua bước duyệt của chính trưởng phòng
        : 'pending_manager';

    HolidayRequest::create([
        'employee_id'   => $employee->id,
        'department_id' => $employee->department_id,
        'holiday_id'    => $request->holiday_id,
        'reason'        => $request->reason,
        'status'        => $status,
    ]);

    return redirect()->route('manager.holiday_requests.index')
        ->with('success', 'Đã gửi đơn đăng ký làm ngày lễ.');
}

    // Duyệt
    public function approve(HolidayRequest $holidayRequest)
    {
        $manager = Auth::user()->employee;

        if ($holidayRequest->department_id !== $manager->department_id) {
            return back()->with('error', 'Bạn không có quyền duyệt đơn này.');
        }

        $holidayRequest->update([
            'status'     => 'pending_admin',
            'manager_id' => $manager->id,
        ]);

        return back()->with('success', 'Đã duyệt, chờ admin phê duyệt.');
    }

    // Từ chối
    public function reject(HolidayRequest $holidayRequest)
    {
        $manager = Auth::user()->employee;

        if ($holidayRequest->department_id !== $manager->department_id) {
            return back()->with('error', 'Bạn không có quyền từ chối đơn này.');
        }

        $holidayRequest->update([
            'status'     => 'rejected_manager',
            'manager_id' => $manager->id,
        ]);

        return back()->with('error', 'Đã từ chối đăng ký.');
    }
}
