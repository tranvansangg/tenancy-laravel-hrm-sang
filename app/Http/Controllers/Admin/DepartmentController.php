<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class DepartmentController extends Controller
{
    
    // Danh sách phòng ban
   public function index()
{
    $departments = Department::with('creator')->get();
    $departments = Department::all();
    return view('admin.departments.index', compact('departments'));
}


    // Form thêm mới
    public function create()
    {
        return view('admin.departments.create');
    }

    // Lưu phòng ban


public function store(Request $request)
{
    $tenantId = tenant('id') ?? auth()->user()->tenant_id;

    $request->validate([
        'code' => [
            'required',
            Rule::unique('departments')->where(fn($q) => $q->where('tenant_id', $tenantId)),
        ],
        'name' => 'required|string|max:255',
    ]);

    $data = $request->all();
    $data['tenant_id'] = $tenantId; // 🟢 thêm tenant_id vào dữ liệu
    $data['status'] = $request->input('status', 0);
    $data['created_by'] = auth()->id();

try{
    Department::create($data);
}catch(QueryException $e){
    if($e->getCode()== '23000'){
        return redirect()->back()
        ->withInput()
        ->withErrors(['code' => 'Mã phòng ban đã tồn tại trong công ty!']);

    }
    throw $e; // Ném lại ngoại lệ nếu không phải lỗi trùng mã
}


    return redirect()->route('admin.departments.index')
        ->with('success', 'Thêm phòng ban thành công!');
}


    // Form sửa
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
{
    $department = Department::findOrFail($id);
    $tenantId = tenant('id') ?? auth()->user()->tenant_id;

    $request->validate([
        'code' => [
            'required',
            Rule::unique('departments')
                
                ->where(fn($q) => $q->where('tenant_id', $tenantId))
                ->ignore($department->id),
        ],
        'name' => 'required|string|max:255',
    ]);

    $data = $request->all();
    $data['status'] = $request->input('status', 0);
    $data['updated_by'] = auth()->id();

    $department->update($data);

    return redirect()->route('admin.departments.index')
        ->with('success', 'Cập nhật phòng ban thành công!');
}


    // Xóa mềm
    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->forceDelete();

        return redirect()->route('admin.departments.index')->with('success', 'Xóa phòng ban thành công!');
    }
}