<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deduction;
use App\Models\Employee;

class DeductionController extends Controller
{
    public function index() {
        $deductions = Deduction::with('employee')->orderBy('id','desc')->paginate(10);
        return view('admin.deductions.index', compact('deductions'));
    }

    public function create() {
        $employees = Employee::all();
        return view('admin.deductions.create', compact('employees'));
    }

    public function store(Request $request) {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'month' => 'required|date',
        ]);

        Deduction::create($request->all());
        return redirect()->route('admin.deductions.index')->with('success','Thêm khấu trừ thành công!');
    }

    public function edit(Deduction $deduction) {
        $employees = Employee::all();
        return view('admin.deductions.edit', compact('deduction','employees'));
    }

    public function update(Request $request, Deduction $deduction) {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'month' => 'required|date',
        ]);

        $deduction->update($request->all());
        return redirect()->route('admin.deductions.index')->with('success','Cập nhật khấu trừ thành công!');
    }

    public function destroy(Deduction $deduction) {
        $deduction->forceDelete();
        return redirect()->route('admin.deductions.index')->with('success','Xóa khấu trừ thành công!');
    }
}
