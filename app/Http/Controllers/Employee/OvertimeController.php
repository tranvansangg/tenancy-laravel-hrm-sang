<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OvertimeEmployee;
use Auth;

class OvertimeController extends Controller
{
    // Hiển thị OT của nhân viên
    public function index()
    {
        $employee = Auth::user()->employee;
        $overtimes = OvertimeEmployee::with('overtime')
                        ->where('employee_id', $employee->id)
                        ->orderBy('created_at','desc')
                        ->get();
        return view('employee.overtimes.index', compact('overtimes'));
    }

    // Nhân viên gửi lý do từ chối OT
public function decline(Request $request, $id)
{
    $otEmployee = OvertimeEmployee::where('id',$id)
                    ->where('employee_id', Auth::user()->employee->id)
                    ->firstOrFail();

    // Không kiểm tra status ở đây, cho phép gửi lý do bất kể Admin đã duyệt hay chưa
    $request->validate([
        'reason'=>'required|string|max:255'
    ]);

    $otEmployee->status = 'employee_declined';  // nhân viên từ chối
    $otEmployee->decline_reason = $request->reason;
    $otEmployee->save();

    return response()->json(['success'=>true]);

    }
}
