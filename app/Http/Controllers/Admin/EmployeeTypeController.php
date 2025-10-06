<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EmployeeTypeController extends Controller
{
    public function index()
    {
        $types = EmployeeType::latest()->paginate(10);
        return view('admin.employee_types.index', compact('types'));
    }

    public function create()
    {
        return view('admin.employee_types.create');
    }
public function store(Request $request)
{
    try {
        $request->validate([
            'code' => [
                'required',
                Rule::unique('employee_types')
                    ->where(fn($query) => $query->where('tenant_id', tenant('id'))),
            ],
            'name' => 'required|string|max:255',
        ]);

        EmployeeType::create([
            'tenant_id'   => tenant('id'),
            'code'        => $request->code,
            'name'        => $request->name,
            'description' => $request->description,
            'created_by'  => auth()->id(),
        ]);

        return redirect()->route('admin.employee_types.index')
                         ->with('success', 'Thêm Loại Nhân Viên thành công!');
    } catch (\Illuminate\Database\QueryException $e) {
        if ($e->getCode() == 23000) { // lỗi trùng unique key
            return back()->withErrors(['code' => 'Mã loại nhân viên đã tồn tại trong công ty này.'])->withInput();
        }
        throw $e;
    }
}

    public function edit(EmployeeType $employee_type)
    {
        return view('admin.employee_types.edit', compact('employee_type'));
    }

     public function update(Request $request, EmployeeType $employee_type)
{
    try {
        $request->validate([
            'code' => [
                'required',
                Rule::unique('employee_types', 'code')
                    ->ignore($employee_type->id)
                    ->where(fn($query) => $query->where('tenant_id', tenant('id'))),
            ],
            'name' => 'required|string|max:255',
        ], [
            'code.unique' => 'Mã loại nhân viên này đã tồn tại trong công ty.',
            'name.required' => 'Tên loại nhân viên không được để trống.',
        ]);

        $employee_type->update([
            'code'        => $request->code,
            'name'        => $request->name,
            'description' => $request->description,
            'updated_by'  => auth()->id(),
        ]);

        return redirect()->route('admin.employee_types.index')
                         ->with('success', 'Cập nhật Loại Nhân Viên thành công!');
    } catch (\Illuminate\Database\QueryException $e) {
        if ($e->getCode() == 23000) { // lỗi trùng unique key
            return back()
                ->withErrors(['code' => 'Mã loại nhân viên đã tồn tại trong công ty này.'])
                ->withInput();
        }

        return back()
            ->withErrors(['error' => 'Cập nhật thất bại: ' . $e->getMessage()])
            ->withInput();
    } catch (\Exception $e) {
        return back()
            ->withErrors(['error' => 'Lỗi không xác định: ' . $e->getMessage()])
            ->withInput();
    }
}

    public function destroy(EmployeeType $employee_type)
    {
        $employee_type->forceDelete();
        return redirect()->route('admin.employee_types.index')
                         ->with('success', 'Xóa Loại Nhân Viên thành công!');
    }
}
