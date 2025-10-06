<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessTrip;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BusinessTripController extends Controller
{
    // Danh sách công tác (chỉ trong phòng ban của mình)
public function index()
{
    $manager = Auth::user()->employee;
    $departmentId = $manager->department_id;

    $trips = BusinessTrip::with('employee')
        ->whereHas('employee', function($q) use ($departmentId) {
            $q->where('department_id', $departmentId);
        })
        ->latest()
        ->paginate(10);

    return view('manager.business_trips.index', compact('trips'));
}

    // Form tạo công tác
// Form tạo công tác
public function create()
{
    $manager = Auth::user()->employee;
    $departmentId = $manager->department_id;

    // lấy danh sách nhân viên trong phòng ban

$employees = Employee::where('department_id', $departmentId)
    ->where('status', 1) // nhân viên đang hoạt động
    ->with([
        'businessTrips' => function($q) {
            $q->whereIn('status', ['pending','approved'])
              ->whereDate('end_date','>=', now());
        },
        'leaves' => function($q) {
            $q->where('status', 'approved')
              ->whereDate('end_date','>=', now());
        }
    ])
    ->get(['id','employee_code','full_name']);
    return view('manager.business_trips.create', compact('employees'));
}

public function store(Request $request)
{
    $manager = Auth::user()->employee;
    $departmentId = $manager->department_id;

    $request->validate([
        'employee_id'   => 'required|exists:employees,id',
        'start_date'    => 'required|date',
        'end_date'      => 'required|date|after_or_equal:start_date',
        'location'      => 'required|string|max:255',
        'purpose'       => 'nullable|string',
        'notes'         => 'nullable|string',
        'estimated_cost'=> 'nullable|numeric'
    ]);

    // check nhân viên có thuộc phòng ban của trưởng phòng không
    $employee = Employee::where('id', $request->employee_id)
        ->where('department_id', $departmentId)
        ->where('status', 1) // chỉ nhân viên đang hoạt động
        ->firstOrFail();

    BusinessTrip::create([
        'trip_code'     => 'BT' . time(),
        'employee_id'   => $employee->id,
        'requested_by'  => $manager->id, // trưởng phòng
        'start_date'    => $request->start_date,
        'end_date'      => $request->end_date,
        'location'      => $request->location,
        'purpose'       => $request->purpose,
        'notes'         => $request->notes,
        'estimated_cost'=> $request->estimated_cost ?? 0,
        'created_by'    => Auth::id(),
        'status'        => 'pending'
    ]);

    return redirect()->route('manager.business_trips.index')
                     ->with('success', 'Đã tạo công tác, chờ admin duyệt.');
}


    // Xem chi tiết công tác
    public function show($id)
    {
        $trip = BusinessTrip::with('employee')->findOrFail($id);
        return view('manager.business_trips.show', compact('trip'));
    }
    public function edit($id)
{
    $trip = BusinessTrip::findOrFail($id);
    return view('manager.business_trips.edit', compact('trip'));
}

public function update(Request $request, $id)
{
    $trip = BusinessTrip::findOrFail($id);

    if ($trip->status !== 'pending') {
        return redirect()->route('manager.business_trips.index')
                         ->with('error', 'Đơn công tác đã được admin xử lý, không thể sửa.');
    }

    $request->validate([
        'title' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'location' => 'required|string|max:255',
        'purpose' => 'required|string',
        'estimated_cost' => 'nullable|numeric|min:0',
    ]);

    $trip->update($request->only(['title','start_date','end_date','location','purpose','notes','estimated_cost']));

    return redirect()->route('manager.business_trips.index')
                     ->with('success', 'Đã cập nhật đơn công tác thành công.');
}

}
