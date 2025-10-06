<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HolidayRequest;
use Illuminate\Support\Facades\Auth;

class HolidayRequestController extends Controller
{
    // Danh sách tất cả đơn chờ duyệt
    public function index()
    {
        $requests = HolidayRequest::with(['holiday', 'employee', 'department'])
            ->where('status', 'pending_admin')
            ->latest()
            ->get();

        return view('admin.holiday_requests.index', compact('requests'));
    }

    // Duyệt
    public function approve(HolidayRequest $holidayRequest)
    {
        $holidayRequest->update([
            'status' => 'approved',
    'admin_id' => Auth::id(), // id của user admin
        ]);

        return back()->with('success', 'Admin đã phê duyệt.');
    }

    // Từ chối
    public function reject(HolidayRequest $holidayRequest)
    {
        $holidayRequest->update([
            'status' => 'rejected',
    'admin_id' => Auth::id(), // id của user admin
        ]);

        return back()->with('error', 'Admin đã từ chối.');
    }
}
