<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EducationLevel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EducationLevelController extends Controller
{
    public function index()
    {
        $educationLevels = EducationLevel::latest()->paginate(10);
        return view('admin.education_levels.index', compact('educationLevels'));
    }

    public function create()
    {
        return view('admin.education_levels.create');
    }

  
public function store(Request $request)
{
  try {
        $request->validate([
            'code' => [
                'required',
                Rule::unique('education_levels', 'code')
                    ->where(fn($query) => $query->where('tenant_id', tenant('id'))),
            ],
            'name' => 'required|string|max:255',
        ]);

        EducationLevel::create([
            'tenant_id'   => tenant('id'),
            'code'        => $request->code,
            'name'        => $request->name,
            'description' => $request->description,
            'created_by'  => auth()->id(),
        ]);


        return redirect()->route('admin.education_levels.index')
            ->with('success', 'Thêm trình độ thành công!');
    } catch (\Illuminate\Database\QueryException $e) {
        if ($e->getCode() == 23000) {
            return back()->withErrors(['code' => 'Mã này đã tồn tại trong công ty.'])->withInput();
        }
        throw $e;
    }
}

    public function edit(EducationLevel $educationLevel)
    {
        return view('admin.education_levels.edit', compact('educationLevel'));
    }
 public function update(Request $request, EducationLevel $educationLevel)
{
    try {
        $request->validate([
            'code' => [
                'required',
                Rule::unique('education_levels', 'code')
                    ->where(function ($query) use ($educationLevel) {
                        return $query->where('tenant_id', tenant('id'))
                                     ->where('id', '!=', $educationLevel->id);
                    }),
            ],
            'name' => 'required|string|max:255',
        ]);

        $educationLevel->update([
            'code'        => $request->code,
            'name'        => $request->name,
            'description' => $request->description,
            'updated_by'  => Auth::id(),
        ]);

        return redirect()
            ->route('admin.education_levels.index')
            ->with('success', 'Cập nhật trình độ thành công!');
    } catch (\Illuminate\Database\QueryException $e) {
        if ($e->getCode() == 23000) { // Lỗi trùng unique key
            return back()
                ->withErrors(['code' => 'Mã trình độ này đã tồn tại trong công ty.'])
                ->withInput();
        }
        throw $e;
    } catch (\Exception $e) {
        return back()
            ->withErrors(['error' => 'Đã xảy ra lỗi: ' . $e->getMessage()])
            ->withInput();
    }
}
    public function destroy(EducationLevel $educationLevel)
    {
        $educationLevel->forceDelete();
        return redirect()->route('admin.education_levels.index')->with('success', 'Xóa trình độ thành công.');
    }
}
