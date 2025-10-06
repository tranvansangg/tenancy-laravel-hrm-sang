<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;


class ManagerEmployeesController extends Controller
{
    public function index()
    {
              $manager = Auth::user()->employee;

        if (!$manager || $manager->position?->name !== 'Trưởng phòng') {
            return back()->with('error', 'Bạn không phải trưởng phòng.');
        }

        // Lấy danh sách nhân viên thuộc cùng phòng
        $employees = Employee::where('department_id', $manager->department_id)
            ->whereHas('position', function ($q) {
                $q->where('name', '!=', 'Trưởng phòng');
            })
            ->get();

        return view('manager.employees.index', compact('employees'));
    }
}
