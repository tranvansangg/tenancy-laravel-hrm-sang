<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\EmployeeGroup;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Employee;


class EmployeeGroupController extends Controller {

    // Xem nhóm
    public function myGroups()
    {
        $employee = Auth::user()->employee;
        $groups = $employee->groups;
        return view('employee.group.index', compact('groups'));
    }
    
// Xin rời nhóm
public function requestExit(Request $request, $groupId)
{
    $employee = Auth::user()->employee;
    $group = Group::findOrFail($groupId);

    $pivot = $group->employees()->where('employee_id', $employee->id)->first();

    if (!$pivot) {
        return back()->with('error', 'Bạn không thuộc nhóm này.');
    }

    // Nếu đang pending thì không cho gửi thêm
    if ($pivot->pivot->status_exit == 'pending') {
        return back()->with('error', 'Bạn đã gửi yêu cầu, vui lòng chờ Leader duyệt.');
    }

    // Nếu đã bị từ chối hoặc chưa có yêu cầu thì cho phép gửi lại
    $group->employees()->updateExistingPivot($employee->id, [
        'reason_exit' => $request->reason,
        'status_exit' => 'pending'
    ]);

    return back()->with('success', 'Yêu cầu rời nhóm đã gửi lại!');
}


    // Leader quản lý nhân viên
    public function editEmployees($groupId) {
        $employee = Auth::user()->employee;
        $group = Group::with('employees')->findOrFail($groupId);

        if($group->leader_id != $employee->id) abort(403);

        if($group->type == 'project'){
            $employees = Employee::all();
        } else{
            $employees = Employee::where('department_id',$employee->department_id)->get();
        }

        return view('employee.groups.edit_employees', compact('group','employees'));
    }

public function updateEmployees(Request $request, $groupId){
    $employee = Auth::user()->employee;
    $group = Group::with('employees')->findOrFail($groupId);

    // Chỉ leader mới được cập nhật
    if($group->leader_id != $employee->id) abort(403);

    $newEmployeeIds = $request->employee_ids ?? [];

    // Luôn giữ leader trong nhóm
    $group->employees()->sync(array_merge([$group->leader_id], $newEmployeeIds));

    return back()->with('success','Cập nhật nhân viên thành công');
}

    // Leader duyệt/từ chối yêu cầu rời nhóm
public function handleExit(Request $request, $groupId, $employeeId)
{
    $group = Group::findOrFail($groupId);

    // Chỉ leader mới được xử lý
    if ($group->leader_id != Auth::user()->employee->id) {
        return back()->with('error', 'Bạn không có quyền xử lý.');
    }

    $employee = $group->employees()->where('employee_id', $employeeId)->first();

    if (!$employee) {
        return back()->with('error', 'Nhân viên không tồn tại trong nhóm.');
    }

    if ($request->action == 'approve') {
        // Xóa hẳn nhân viên ra khỏi nhóm
        $group->employees()->detach($employeeId);

        return back()->with('success', 'Đã duyệt và xóa nhân viên khỏi nhóm.');
    }

    if ($request->action == 'reject') {
        $group->employees()->updateExistingPivot($employeeId, [
            'status_exit' => 'rejected',
            'reason_exit' => $request->reason_response
        ]);

        return back()->with('success', 'Đã từ chối yêu cầu rời nhóm.');
    }

    return back()->with('error', 'Hành động không hợp lệ.');
}


}
