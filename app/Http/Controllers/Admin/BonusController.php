<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bonus;
use App\Models\Employee;

class BonusController extends Controller
{
    public function index() {
        $bonuses = Bonus::with('employee')->orderBy('id','desc')->paginate(10);
        return view('admin.bonuses.index', compact('bonuses'));
    }

    public function create() {
        $employees = Employee::all();
        return view('admin.bonuses.create', compact('employees'));
    }

    public function store(Request $request) {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'month' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        Bonus::create($request->all());
        return redirect()->route('admin.bonuses.index')->with('success','Thêm khen thưởng thành công!');
    }

    public function edit(Bonus $bonus) {
        $employees = Employee::all();
        return view('admin.bonuses.edit', compact('bonus','employees'));
    }

    public function update(Request $request, Bonus $bonus) {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'month' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $bonus->update($request->all());
        return redirect()->route('admin.bonuses.index')->with('success','Cập nhật khen thưởng thành công!');
    }

    public function destroy(Bonus $bonus) {
        $bonus->forceDelete();
        return redirect()->route('admin.bonuses.index')->with('success','Xóa khen thưởng thành công!');
    }
}
