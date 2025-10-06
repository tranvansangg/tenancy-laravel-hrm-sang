<?php

namespace App\Http\Controllers\Admin;
use App\Models\Holiday;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class HolidayController extends Controller
{
    // Danh sách ngày lễ
    public function index()
    {
        $holidays = Holiday::orderBy('date', 'asc')->get();
        return view('admin.holidays.index', compact('holidays'));
    }

    // Form tạo ngày lễ
    public function create()
    {
        return view('admin.holidays.create');
    }

    // Lưu ngày lễ
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|unique:holidays,date',
            'description' => 'nullable|string|max:255',
        ]);

        Holiday::create($request->all());

        return redirect()->route('admin.holidays.index')->with('success', 'Tạo ngày lễ thành công!');
    }

    // Form sửa
    public function edit(Holiday $holiday)
    {
        return view('admin.holidays.edit', compact('holiday'));
    }

    // Cập nhật
    public function update(Request $request, Holiday $holiday)
    {
        $request->validate([
            'date' => 'required|date|unique:holidays,date,' . $holiday->id,
            'description' => 'nullable|string|max:255',
        ]);

        $holiday->update($request->all());

        return redirect()->route('admin.holidays.index')->with('success', 'Cập nhật ngày lễ thành công!');
    }

    // Xóa
    public function destroy(Holiday $holiday)
    {
        $holiday->forceDelete();
        return redirect()->route('admin.holidays.index')->with('success', 'Xóa ngày lễ thành công!');
    }
}
