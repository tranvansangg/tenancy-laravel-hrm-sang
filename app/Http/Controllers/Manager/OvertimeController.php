<?php
namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Overtime;
use App\Models\OvertimeEmployee;
use App\Models\Employee;
use Carbon\Carbon;

class OvertimeController extends Controller
{
    // Hiển thị mảng OT của phòng
    public function index()
    {
        $manager = Auth::user()->employee;
        if (!$manager || $manager->position?->name !== 'Trưởng phòng') {
            return back()->with('error','Bạn không phải trưởng phòng.');
        }

        $overtimes = Overtime::with(['employees.employee'])
            ->where('department_id', $manager->department_id)
            ->orderBy('date','desc')
            ->get();

        return view('manager.overtimes.index', compact('overtimes'));
    }

   public function create(Request $request)
{
    $manager = Auth::user()->employee;
    if (!$manager || $manager->position?->name !== 'Trưởng phòng') {
        return back()->with('error','Bạn không phải trưởng phòng.');
    }

    // Nếu chưa chọn ngày thì hiển thị form chọn ngày
    if (!$request->has('date')) {
        return view('manager.overtimes.choose_date');
    }

    $date = $request->input('date');

    // Kiểm tra ngày đó có phải lễ không
    $holiday = \App\Models\Holiday::whereDate('date', $date)->first();

    if ($holiday) {
        // Nếu là ngày lễ → chỉ lấy nhân viên đã đăng ký làm việc ngày lễ và được duyệt
        $employees = Employee::where('department_id', $manager->department_id)
            ->whereHas('holidayRequests', function($q) use ($holiday) {
                $q->where('holiday_id', $holiday->id)
                  ->where('status', 'approved');
            })
            ->get();
    } else {
        // Nếu không phải ngày lễ → lấy nhân viên phòng ban, trừ nhân viên nghỉ phép
        $employees = Employee::where('department_id', $manager->department_id)
            ->whereDoesntHave('leaves', function($q) use ($date) {
                $q->where('status', 'approved')
                  ->whereDate('start_date', '<=', $date)
                  ->whereDate('end_date', '>=', $date);
            })
            ->get();
    }

    return view('manager.overtimes.create', compact('employees','date'));
}


    // Tạo OT cho nhiều nhân viên
    public function store(Request $request)
    {
        $manager = Auth::user()->employee;

        $request->validate([
            'employee_ids'=>'required|array',
            'date'=>'required|date',
            'start_time'=>'required',
            'end_time'=>'required',
            'reason'=>'required|string'
        ]);

        $overtime = Overtime::create([
            'department_id'=>$manager->department_id,
            'creator_id'=>$manager->id,
            'date'=>$request->date,
            'start_time'=>$request->start_time,
            'end_time'=>$request->end_time,
            'reason'=>$request->reason,
            'status'=>'pending'
        ]);

        // Tạo bản ghi overtime_employee cho từng nhân viên
        foreach($request->employee_ids as $emp_id){
            $overtime->employees()->create([
                'employee_id'=>$emp_id,
                'status'=>'pending'
            ]);
        }

        return redirect()->route('manager.overtimes.index')->with('success','OT đã được tạo.');
    }

    // Nhận danh sách nhân viên từ chối → chấp nhận loại khỏi mảng
    public function acceptDecline(Request $request, $id)
    {
        $otEmployee = OvertimeEmployee::findOrFail($id);
        $otEmployee->status = 'manager_declined';
        $otEmployee->save();

        return response()->json(['success'=>true]);
    }

    // Từ chối lý do nhân viên → giữ trong OT
    public function rejectDecline(Request $request, $id)
    {
        $otEmployee = OvertimeEmployee::findOrFail($id);
        $otEmployee->status = 'pending';
        $otEmployee->save();

        return response()->json(['success'=>true]);
    }
}
