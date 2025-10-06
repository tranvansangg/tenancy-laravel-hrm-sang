<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessTrip;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class BusinessTripController extends Controller
{
    // Danh sách công tác
    public function index()
    {
        $trips = BusinessTrip::with('employee','employee.department')
            ->latest()
            ->paginate(15);

        return view('admin.business_trips.index', compact('trips'));
    }

    // Xem chi tiết công tác
    public function show($id)
    {
        $trip = BusinessTrip::with('employee','employee.department')->findOrFail($id);
        return view('admin.business_trips.show', compact('trip'));
    }

    // Admin duyệt công tác
    public function approve(Request $request, $id)
    {
        $trip = BusinessTrip::findOrFail($id);

        $trip->update([
            'status' => 'approved',
            'admin_feedback' => $request->admin_feedback ?? 'Đã duyệt',
        ]);

        return redirect()->route('admin.business_trips.index')->with('success', 'Công tác đã được duyệt.');
    }

    // Admin từ chối công tác
    public function reject(Request $request, $id)
    {
        $trip = BusinessTrip::findOrFail($id);

        $trip->update([
            'status' => 'rejected',
            'admin_feedback' => $request->admin_feedback ?? 'Bị từ chối',
        ]);

        return redirect()->route('admin.business_trips.index')->with('error', 'Công tác đã bị từ chối.');
    }

    // Admin cập nhật chi phí thực tế & báo cáo sau công tác
    public function edit($id)
    {
        $trip = BusinessTrip::findOrFail($id);
        return view('admin.business_trips.edit', compact('trip'));
    }

    public function update(Request $request, $id)
    {
        $trip = BusinessTrip::findOrFail($id);

        $request->validate([
            'actual_cost' => 'nullable|numeric',
            'report'      => 'nullable|string'
        ]);

        $trip->update([
            'actual_cost' => $request->actual_cost,
            'report'      => $request->report,
            'status'      => $request->status ?? $trip->status,
        ]);

        return redirect()->route('admin.business_trips.index')->with('success', 'Cập nhật công tác thành công.');
    }

    public function destroy($id)
    {
        $trip = BusinessTrip::findOrFail($id);
        $trip->forceDelete();
        return redirect()->route('admin.business_trips.index')->with('success', 'Đã xóa công tác.');
    }
    
}
