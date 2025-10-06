<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::latest()->paginate(10);
        
        return view('admin.specialties.index', compact('specialties'));
    }

      public function create()
    {
        return view('admin.specialties.create');
    }

    public function store(Request $request)
    {
        try {
        $request->validate([
            'code' => [
                'required',
                Rule::unique('specialties', 'code')
                    ->where(fn($query) => $query->where('tenant_id', tenant('id'))),
            ],
            'name' => 'required|string|max:255',
        ]);

        Specialty::create([
            'tenant_id'   => tenant('id'),
            'code'        => $request->code,
            'name'        => $request->name,
            'description' => $request->description,
            'created_by'  => auth()->id(),
        ]);

        return redirect()->route('admin.specialties.index')
                         ->with('success', 'Thêm Loại Nhân Viên thành công!');
    } catch (\Illuminate\Database\QueryException $e) {
        if ($e->getCode() == 23000) { // lỗi trùng unique key
            return back()->withErrors(['code' => 'Mã loại nhân viên đã tồn tại trong công ty này.'])->withInput();
        }
        throw $e;
    }
}
    public function edit(Specialty $specialty)
    {
        return view('admin.specialties.edit', compact('specialty'));
    }

public function update(Request $request, Specialty $specialty)
{
    try {
        $request->validate([
            'code' => [
                'required',
                Rule::unique('specialties')
                    ->where(function ($query) use ($specialty) {
                        return $query->where('tenant_id', tenant('id'))
                                     ->where('id', '!=', $specialty->id);
                    }),
            ],
            'name' => 'required|string|max:255',
        ]);

        $specialty->update([
            'code'        => $request->code,
            'name'        => $request->name,
            'description' => $request->description,
            'updated_by'  => auth()->id(),
        ]);

        return redirect()
            ->route('admin.specialties.index')
            ->with('success', 'Cập nhật chuyên môn thành công!');
    } catch (\Illuminate\Database\QueryException $e) {
        if ($e->getCode() == 23000) {
            return back()
                ->withErrors(['code' => 'Mã chuyên môn đã tồn tại trong công ty này.'])
                ->withInput();
        }
        throw $e;
    } catch (\Exception $e) {
        return back()
            ->withErrors(['error' => 'Đã xảy ra lỗi: ' . $e->getMessage()])
            ->withInput();
    }
}

    public function destroy(Specialty $specialty)
    {
        $specialty->forceDelete();
        return redirect()->route('admin.specialties.index')
                         ->with('success', 'Xóa Chuyên môn thành công!');
    }
}