<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Allowance;
use App\Models\Employee;

class AllowanceController extends Controller
{
    public function index() {
        $allowances = Allowance::with('employee')->orderBy('id','desc')->paginate(10);
        return view('admin.allowances.index', compact('allowances'));
    }

    public function create() {
        $employees = Employee::all();
        return view('admin.allowances.create', compact('employees'));
    }

public function store(Request $request) {
    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'type' => 'required|string',
        'amount' => 'required|numeric|min:0',
        'month' => 'required|string|regex:/^\d{4}-\d{2}$/', // YYYY-MM
    ]);

    // Chuyển sang YYYY-MM-01 để lưu DB
    $month_date = $request->month . '-01';

    Allowance::create([
        'employee_id' => $request->employee_id,
        'type' => $request->type,
        'amount' => $request->amount,
        'month' => $month_date,
    ]);

    return redirect()->route('admin.allowances.index')->with('success','Thêm phụ cấp thành công!');
}

    public function edit(Allowance $allowance) {
        $employees = Employee::all();
        return view('admin.allowances.edit', compact('allowance','employees'));
    }

  

public function update(Request $request, Allowance $allowance) {
    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'type' => 'required|string',
        'amount' => 'required|numeric|min:0',
        'month' => 'required|string|regex:/^\d{4}-\d{2}$/', // chỉ YYYY-MM
    ]);

    $month_date = $request->month . '-01';

    $allowance->update([
        'employee_id' => $request->employee_id,
        'type' => $request->type,
        'amount' => $request->amount,
        'month' => $month_date,
    ]);

    return redirect()->route('admin.allowances.index')->with('success','Cập nhật phụ cấp thành công!');
}


    public function destroy(Allowance $allowance) {
        $allowance->forceDelete();
        return redirect()->route('admin.allowances.index')->with('success','Xóa phụ cấp thành công!');
    }
}
