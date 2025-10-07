<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class DepartmentController extends Controller
{
    /**
     * Lấy tenant ID hiện tại theo user login hoặc domain
     */

 protected function getTenantId()
{
    // Nếu có package Laravel Tenancy
    if (function_exists('tenant') && tenant()) {
        return tenant('id');
    }

    // Lấy từ user login
    $user = auth()->user();
    if ($user && $user->tenant_id) {
        return $user->tenant_id;
    }

    // Hoặc lấy theo domain
    $host = request()->getHost();
    $tenant = Tenant::where('domain', $host)->first();
    if ($tenant) {
        return $tenant->id;
    }

    abort(400, 'Tenant không xác định.');
}


    /**
     * Danh sách phòng ban theo tenant
     */
    public function index()
    {
        $tenantId = $this->getTenantId();

        $departments = Department::with('creator')
            ->where('tenant_id', $tenantId)
            ->get();

        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Form tạo mới phòng ban
     */
    public function create()
    {
        return view('admin.departments.create');
    }

    /**
     * Lưu phòng ban
     */
  public function store(Request $request)
{
    // Lấy tenant hiện tại: từ user login hoặc domain
    $tenantId = $this->getTenantId();

    $request->validate([
        'code' => [
            'required',
            Rule::unique('departments')->where(fn($q) => $q->where('tenant_id', $tenantId)),
        ],
        'name' => 'required|string|max:255',
    ]);

    $data = $request->only(['code', 'name', 'description']);
    $data['tenant_id'] = $tenantId; // tự động gán tenant hiện tại
    $data['status'] = $request->input('status', 1);
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


    /**
     * Form sửa phòng ban
     */
    public function edit($id)
    {
        $tenantId = $this->getTenantId();

        $department = Department::where('tenant_id', $tenantId)->findOrFail($id);

        return view('admin.departments.edit', compact('department'));
    }

 
public function update(Request $request, $id)
{
    $tenantId = $this->getTenantId();

    $department = Department::where('tenant_id', $tenantId)->findOrFail($id);

    $request->validate([
        'code' => [
            'required',
            Rule::unique('departments')
                ->where(fn($q) => $q->where('tenant_id', $tenantId))
                ->ignore($department->id),
        ],
        'name' => 'required|string|max:255',
    ]);

    $data = $request->only(['code', 'name', 'description']);
    $data['status'] = $request->input('status', 1);
    $data['updated_by'] = auth()->id();

    $department->update($data);

    return redirect()->route('admin.departments.index')
        ->with('success', 'Cập nhật phòng ban thành công!');
}

    /**
     * Xóa phòng ban
     */
    public function destroy($id)
    {
        $tenantId = $this->getTenantId();

        $department = Department::where('tenant_id', $tenantId)->findOrFail($id);
        $department->forceDelete(); // hoặc delete() nếu muốn xóa mềm

        return redirect()->route('admin.departments.index')
            ->with('success', 'Xóa phòng ban thành công!');
    }
}
