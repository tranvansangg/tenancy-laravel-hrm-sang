<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InsuranceRecord;
use App\Models\Employee;
use Illuminate\Http\Request;

class InsuranceRecordController extends Controller
{
    public function index()
    {
        $records = InsuranceRecord::with('employee')->paginate(10);
        return view('admin.insurances_records.index', compact('records'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('admin.insurances_records.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'participation_date' => 'required|date',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        InsuranceRecord::create($request->all());
        return redirect()->route('admin.insurances_records.index')->with('success', 'Thêm BHXH thành công');
    }

    public function show($id)
    {
        $record = InsuranceRecord::with('employee')->findOrFail($id);
        return view('admin.insurances_records.show', compact('record'));
    }

    public function edit($id)
    {
        $record = InsuranceRecord::findOrFail($id);
        $employees = Employee::all();
        return view('admin.insurances_records.edit', compact('record', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $record = InsuranceRecord::findOrFail($id);

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'participation_date' => 'required|date',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $record->update($request->all());
        return redirect()->route('admin.insurances_records.index')->with('success', 'Cập nhật BHXH thành công');
    }

    public function destroy($id)
    {
        $record = InsuranceRecord::findOrFail($id);
        $record->forceDelete();
        return redirect()->route('admin.insurances_records.index')->with('success', 'Xoá BHXH thành công');
    }
}
