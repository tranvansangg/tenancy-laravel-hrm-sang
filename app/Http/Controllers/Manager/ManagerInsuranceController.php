<?php

namespace App\Http\Controllers\Manager;

use App\Models\InsuranceRecord;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ManagerInsuranceController extends Controller
{
    // Trưởng phòng xem bảo hiểm của chính mình
    public function myInsurance()
    {
        $manager = Auth::user()->employee;

        if (!$manager || $manager->position?->name !== 'Trưởng phòng') {
            return back()->with('error', 'Bạn không phải trưởng phòng.');
        }

        $records = InsuranceRecord::where('employee_id', $manager->id)->get();

        return view('manager.insurance.my', compact('manager','records'));
    }

    // Trưởng phòng xem bảo hiểm của nhân viên trong phòng mình
    public function show($employee_id)
    {
        $manager = Auth::user()->employee;

        if (!$manager || $manager->position?->name !== 'Trưởng phòng') {
            return back()->with('error', 'Bạn không phải trưởng phòng.');
        }

        // Tìm nhân viên thuộc phòng ban của trưởng phòng
        $employee = Employee::where('department_id', $manager->department_id)
                            ->findOrFail($employee_id);

        $records = InsuranceRecord::where('employee_id', $employee_id)->get();

        return view('manager.insurance.show', compact('employee','records'));
    }
      public function index()
    {
        $manager = Auth::user()->employee;

        if (!$manager || $manager->position?->name !== 'Trưởng phòng') {
            return back()->with('error', 'Bạn không phải trưởng phòng.');
        }

        // Lấy toàn bộ nhân viên trong phòng ban (trừ chính trưởng phòng)
        $employees = Employee::where('department_id', $manager->department_id)
                             ->where('id','!=',$manager->id)
                             ->with('insuranceRecords')
                             ->get();

        return view('manager.insurance.index', compact('manager','employees'));
    }
}
