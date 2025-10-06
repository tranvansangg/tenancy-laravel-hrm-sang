<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Degree;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use Illuminate\Validation\Rule;


class DegreeController extends Controller
{
    // Hiển thị danh sách
    public function index()
    {
     
        $degrees = Degree::paginate(10); // phân trang 10 bản ghi
        return view('admin.degrees.index', compact('degrees'));
    }

    // Form thêm mới
    public function create()
    {
        return view('admin.degrees.create');
    }

    // Lưu dữ liệu mới
public function store(Request $request)
{
    $tenantId = tenant('id') ?? auth()->user()->tenant_id;

    $request->validate([
        'code' => [
            'required',
            Rule::unique('degrees')->where(fn($q) => $q->where('tenant_id', $tenantId)),
        ],
        'name' => 'required|string',
    ]);

    $data = $request->all();
    $data['status'] = $request->has('status') ? 1 : 0;
    $data['created_by'] = auth()->id();
    $data['tenant_id'] = $tenantId; // 🟢 thêm tenant_id khi lưu

    Degree::create($data);

    return redirect()->route('admin.degrees.index')
        ->with('success', 'Đã thêm bằng cấp mới thành công!');
}

    // Form sửa
    public function edit(Degree $degree)
    {
        return view('admin.degrees.edit', compact('degree'));
    }

    // Cập nhật dữ liệu
public function update(Request $request, Degree $degree)
{
    $tenantId = tenant('id') ?? auth()->user()->tenant_id;

    try {
        $request->validate([
            'code' => [
                'required',
                Rule::unique('degrees', 'code')
                    ->where(fn($q) => $q->where('tenant_id', $tenantId))
                    ->ignore($degree->id),
            ],
            'name' => 'required|string',
        ], [
            'code.required' => 'Mã bằng cấp không được để trống.',
            'code.unique'   => 'Mã bằng cấp này đã tồn tại trong công ty.',
            'name.required' => 'Tên bằng cấp không được để trống.',
        ]);

        $data = $request->all();
        $data['status'] = $request->has('status') ? 1 : 0;
        $data['updated_by'] = auth()->id();

        $degree->update($data);

        return redirect()->route('admin.degrees.index')
            ->with('success', 'Cập nhật bằng cấp thành công!');
    } catch (\Illuminate\Database\QueryException $e) {
        if ($e->getCode() == 23000) { // Lỗi trùng unique key
            return back()
                ->withErrors(['code' => 'Mã bằng cấp đã tồn tại trong công ty này.'])
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


    // Xóa
  public function destroy(Degree $degree)
{
    $degree->forceDelete(); // xóa bản ghi khỏi DB hoàn toàn
    return redirect()->route('admin.degrees.index')
        ->with('success', 'Đã xóa bằng cấp hoàn toàn!');
}

}
