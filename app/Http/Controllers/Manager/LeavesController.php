<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\InsuranceRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LeavesController extends Controller
{
    // Danh sách đơn nghỉ phép của nhân viên trong phòng// Danh sách đơn nghỉ phép của nhân viên trong phòng
public function index()
{
    $manager = Auth::user()->employee;

    if (!$manager || $manager->position?->name !== 'Trưởng phòng') {
        return back()->with('error', 'Bạn không phải là trưởng phòng.');
    }

    // Lấy danh sách id nhân viên cùng phòng, trừ chính trưởng phòng
    $employeeIds = Employee::where('department_id', $manager->department_id)
        ->where('id', '!=', $manager->id) // bỏ trưởng phòng ra
        ->pluck('id');

    $leaves = Leave::with('employee')
        ->whereIn('employee_id', $employeeIds)
        ->orderBy('created_at', 'desc')
        ->paginate(15);

    return view('manager.leaves.index', compact('leaves', 'manager'));
}


    // Danh sách đơn nghỉ phép của trưởng phòng
   // Danh sách đơn nghỉ phép của trưởng phòng
public function myLeaves()
{
    $manager = Auth::user()->employee;
    if (!$manager || $manager->position?->name !== 'Trưởng phòng') {
        return back()->with('error','Bạn không phải là trưởng phòng.');
    }

    $leaves = Leave::where('employee_id', $manager->id)
        ->orderBy('created_at','desc')
        ->paginate(15);

    return view('manager.leaves.my_leaves', compact('leaves','manager'));
}


    // Form tạo đơn nghỉ phép cho trưởng phòng
    public function create()
    {
        $manager = Auth::user()->employee;
        if (!$manager || $manager->position?->name !== 'Trưởng phòng') {
            return back()->with('error','Bạn không phải là trưởng phòng.');
        }

        $leaveTypes = $this->getAvailableLeaveTypes($manager);
        $remainingAnnualLeave = $this->getRemainingAnnualLeave($manager);

        return view('manager.leaves.create', compact('leaveTypes','remainingAnnualLeave','manager'));
    }

    // Lưu đơn nghỉ phép trưởng phòng
    public function store(Request $request)
    {
        $manager = Auth::user()->employee;
        if (!$manager || $manager->position?->name !== 'Trưởng phòng') {
            return back()->with('error','Bạn không phải là trưởng phòng.');
        }

        $days = Carbon::parse($request->start_date)->diffInDays(Carbon::parse($request->end_date)) + 1;
        $fileRequired = false;
        $is_paid = false;

        $leaveTypes = $this->getAvailableLeaveTypes($manager);
        $hasInsurance = in_array('sick', $leaveTypes);

        switch($request->leave_type){
            case 'annual':
                $remaining = $this->getRemainingAnnualLeave($manager);
                if($remaining <= 0) return back()->with('error','Bạn đã hết số ngày phép còn lại.');
                $days = min($days, $remaining);
                $is_paid = true;
                break;

            case 'unpaid':
                $is_paid = false;
                if($days > 7) $fileRequired = true;
                break;

    case 'sick':
    if(!$hasInsurance) return back()->with('error','Chỉ nhân viên có BHXH mới được nghỉ ốm.');
    $days = $this->getRemainingSickLeaveDays($manager);
    $is_paid = false; // bắt buộc nghỉ không lương
    break;

case 'maternity':
    if(!$hasInsurance) return back()->with('error','Chỉ nhân viên có BHXH mới được nghỉ thai sản.');
    $days = 180;
    $is_paid = false; // nghỉ thai sản -> không lương
    break;

default:
    return back()->with('error','Loại đơn nghий phép không hợp lệ.');
        }

        $request->validate([
            'reason'=>'required|string',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after_or_equal:start_date',
            'document'=>($fileRequired?'required':'nullable').'|file|mimes:jpeg,png,jpg,pdf|max:2048'
        ]);

        $documentPath = $request->hasFile('document') 
            ? $request->file('document')->store('leave_documents','public')
            : null;

        Leave::create([
            'employee_id'=>$manager->id,
            'leave_type'=>$request->leave_type,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'days'=>$days,
            'status'=>'pending',
            'is_paid'=>$is_paid,
            'reason'=>$request->reason,
            'document'=>$documentPath
        ]);

        return redirect()->route('manager.leaves.my_leaves')
            ->with('success','Đơn nghỉ phép đã được gửi, chờ duyệt.');
    }

    // Sửa đơn nghỉ phép chưa duyệt
    public function edit($id)
    {
        $manager = Auth::user()->employee;
        $leave = Leave::where('id',$id)
            ->where('employee_id',$manager->id)
            ->where('status','pending')
            ->firstOrFail();

        $leaveTypes = $this->getAvailableLeaveTypes($manager);
        $remainingAnnualLeave = $this->getRemainingAnnualLeave($manager);

        return view('manager.leaves.edit', compact('leave','leaveTypes','remainingAnnualLeave','manager'));
    }

    public function update(Request $request, $id)
    {
        $manager = Auth::user()->employee;
        $leave = Leave::where('id',$id)
            ->where('employee_id',$manager->id)
            ->where('status','pending')
            ->firstOrFail();

        $days = Carbon::parse($request->start_date)->diffInDays(Carbon::parse($request->end_date)) + 1;
        $fileRequired = false;
        $is_paid = false;

        $leaveTypes = $this->getAvailableLeaveTypes($manager);
        $hasInsurance = in_array('sick', $leaveTypes);

        switch($request->leave_type){
            case 'annual':
                $remaining = $this->getRemainingAnnualLeave($manager);
                if($remaining <= 0) return back()->with('error','Bạn đã hết số ngày phép còn lại.');
                $days = min($days, $remaining);
                $is_paid = true;
                break;

            case 'unpaid':
                $is_paid = false;
                if($days > 7) $fileRequired = true;
                break;

            case 'sick':
                if(!$hasInsurance) return back()->with('error','Chỉ nhân viên có BHXH mới được nghỉ ốm.');
                $days = $this->getRemainingSickLeaveDays($manager);
                $is_paid = false;
                $fileRequired = true;
                break;

            case 'maternity':
                if(!$hasInsurance) return back()->with('error','Chỉ nhân viên có BHXH mới được nghỉ thai sản.');
                $days = 180;
                $is_paid = false;
                $fileRequired = true;
                break;
        }

        $request->validate([
            'reason'=>'required|string',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after_or_equal:start_date',
            'document'=>($fileRequired?'required':'nullable').'|file|mimes:jpeg,png,jpg,pdf|max:2048'
        ]);

        $doc = $leave->document;
        if($request->hasFile('document')){
            if($doc) Storage::disk('public')->delete($doc);
            $doc = $request->file('document')->store('leave_documents','public');
        }

        $leave->update([
            'leave_type'=>$request->leave_type,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'days'=>$days,
            'is_paid'=>$is_paid,
            'reason'=>$request->reason,
            'document'=>$doc
        ]);

        return redirect()->route('manager.leaves.my_leaves')
            ->with('success','Đơn nghỉ phép đã được cập nhật.');
    }

    // Duyệt hoặc từ chối đơn nhân viên (có manager_note)
    public function approve(Request $request, $id)
    {
        $manager = Auth::user()->employee;
        $leave = Leave::with('employee')->findOrFail($id);

        if($leave->employee->department_id != $manager->department_id){
            return back()->with('error','Bạn không có quyền duyệt đơn này.');
        }

        $request->validate([
            'status'=>'required|in:approved,rejected',
            'manager_note'=>'nullable|string'
        ]);

        $leave->update([
            'status'=>$request->status,
            'manager_note'=>$request->manager_note
        ]);

        return redirect()->route('manager.leaves.index')
            ->with('success','Đơn nghỉ phép đã được cập nhật.');
    }

    // ====== Hỗ trợ ======
    protected function getAvailableLeaveTypes($employee)
    {
        $types = [];
        $remainingAnnualLeave = $this->getRemainingAnnualLeave($employee);
        if ($remainingAnnualLeave>0) $types[] = 'annual';

        $hasInsurance = InsuranceRecord::where('employee_id', $employee->id)
            ->where('status', 'active')
            ->whereDate('participation_date','<=',now())
            ->exists();

        if($hasInsurance){
            $types[] = 'sick';
            $types[] = 'maternity';
        }

        $types[] = 'unpaid';
        return $types;
    }
protected function getRemainingAnnualLeave($employee)
{
    // Tổng số ngày công đã làm trong năm nay
    $actualWorkedDays = \DB::table('attendances')
        ->where('employee_id', $employee->id)
        ->whereYear('date', Carbon::now()->year)
        ->where('status', 'present') // hoặc 'working'
        ->count();

    // Cứ 26 ngày làm việc thực tế = 1 ngày phép năm
    $earnedLeaveDays = floor($actualWorkedDays / 26);

    // Ngày phép đã dùng
    $used = Leave::where('employee_id', $employee->id)
        ->where('leave_type', 'annual')
        ->where('is_paid', true)
        ->where('status', 'approved')
        ->whereYear('start_date', Carbon::now()->year)
        ->sum('days');

    // Phép còn lại
    return max($earnedLeaveDays - $used, 0);
}

// Hiển thị chi tiết đơn nghỉ phép
public function show($id)
{
    $manager = Auth::user()->employee;

    $leave = Leave::with('employee')
        ->whereIn('employee_id', Employee::where('department_id', $manager->department_id)->pluck('id'))
        ->findOrFail($id);

    // Nếu đơn là của trưởng phòng -> chỉ hiển thị, không cho duyệt
    $canApprove = $leave->employee->id != $manager->id && $leave->status == 'pending';

    return view('manager.leaves.show', compact('leave','canApprove','manager'));
}


}
