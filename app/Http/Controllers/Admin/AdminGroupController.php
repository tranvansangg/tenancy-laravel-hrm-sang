<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;




    // Danh sách nhóm
 class AdminGroupController extends Controller {

public function indexGroups()
{
    $tenantId = Auth::user()->tenant_id;

    // Lấy tất cả nhóm của tenant hiện tại, không join bảng khác
    $groups = Group::where('tenant_id', $tenantId)->get();
    $employees = Employee::where('tenant_id', $tenantId)->get();
    

    return view('admin.groups.index', compact('groups', 'employees'));
}






    public function createGroup() {
        $employees = Employee::all();
        return view('admin.groups.create',compact('employees'));
    }

public function storeGroup(Request $request) {
    $request->validate([
        'name'=>'required|string',
        'type'=>'required|in:project,department',
        'leader_id'=>'required|exists:employees,id'
    ]);

    $tenantId = Auth::user()->tenant_id;

    // Tạo nhóm và gán tenant_id
    $group = Group::create([
        'name' => $request->name,
        'type' => $request->type,
        'leader_id' => $request->leader_id,
        'description' => $request->description,
        // 'tenant_id' => $tenantId, // gán tenant_id cho nhóm
    ]);

    // Attach leader vào pivot và gán tenant_id
    $group->employees()->attach($request->leader_id, [
        'joined_at' => now(),
        // 'tenant_id' => $tenantId, // gán tenant_id cho pivot
    ]); 

    session()->flash('leader_assigned','Nhân viên được chọn làm leader!');
    return redirect()->route('admin.groups.index')->with('success','Tạo nhóm thành công');
}


    // Thay đổi leader
    public function editLeader($id){
        $group = Group::findOrFail($id);
        $employees = Employee::all();
        $leaders = Employee::all();
        return view('admin.groups.edit',compact('group','employees','leaders'));
    }

    public function updateLeader(Request $request,$id){
        $request->validate(['leader_id'=>'required|exists:employees,id']);
        $group = Group::findOrFail($id);
        $group->leader_id = $request->leader_id;
        $group->save();
        session()->flash('leader_assigned','Bạn đã được chọn làm leader!');
        return redirect()->route('admin.groups.index')->with('success','Cập nhật leader thành công');
    }

    // Toggle trạng thái nhóm
    public function toggleGroupStatus($id){
        $group = Group::findOrFail($id);
        $group->status = $group->status == 'active' ? 'inactive':'active';
        $group->save();
        return back()->with('success','Cập nhật trạng thái nhóm thành công');
    }
}


