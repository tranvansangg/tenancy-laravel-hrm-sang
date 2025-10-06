<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\EmployeeGroup;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use DB;

class ManagerGroupController extends Controller
{
    // Xem nhóm Trưởng phòng quản lý
// ...existing code...
    public function myGroups()
    {
        $tenantId = Auth::user()->tenant_id;
    $groups = Group::where('tenant_id', $tenantId)->get();
    $employees = Employee::where('tenant_id', $tenantId)->get();
    
    
        return view('manager.groups.index', compact('employees','groups'));
    }
// ...existing code...

    // Leader quản lý nhân viên
    public function editEmployees($groupId)
    {
        $manager = Auth::user()->employee;
        if (!$manager || $manager->position?->name !== 'Trưởng phòng') {
            return back()->with('error','Bạn không phải là trưởng phòng.');
        }

        $group = Group::with('employees')->findOrFail($groupId);

        if($group->leader_id != $manager->id) abort(403);

        $employees = Employee::all();

        return view('manager.groups.edit_employees', compact('group','employees'));
    }

    public function updateEmployees(Request $request, $groupId)
    {
        $manager = Auth::user()->employee;
        if (!$manager || $manager->position?->name !== 'Trưởng phòng') {
            return back()->with('error','Bạn không phải là trưởng phòng.');
        }

        $group = Group::with('employees')->findOrFail($groupId);

        if($group->leader_id != $manager->id) abort(403);

        $newEmployeeIds = $request->employee_ids ?? [];

        // Luôn giữ leader trong nhóm
        $group->employees()->sync(array_merge([$group->leader_id], $newEmployeeIds));

        return back()->with('success','Cập nhật nhân viên thành công');
    }

    // Leader duyệt/từ chối yêu cầu rời nhóm
    public function handleExit(Request $request, $groupId, $employeeId)
    {
        $manager = Auth::user()->employee;
        if (!$manager || $manager->position?->name !== 'Trưởng phòng') {
            return back()->with('error','Bạn không phải là trưởng phòng.');
        }

        $group = Group::findOrFail($groupId);

        if ($group->leader_id != $manager->id) {
            return back()->with('error', 'Bạn không có quyền xử lý.');
        }

        $employee = $group->employees()->where('employee_id', $employeeId)->first();

        if (!$employee) {
            return back()->with('error', 'Nhân viên không tồn tại trong nhóm.');
        }

        if ($request->action == 'approve') {
            $groupName = $group->name;
            $group->employees()->detach($employeeId);
            return back()->with('success', "Đã duyệt và xóa nhân viên khỏi nhóm '{$groupName}'");
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
