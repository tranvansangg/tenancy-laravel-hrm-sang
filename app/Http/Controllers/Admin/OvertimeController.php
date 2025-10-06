<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Overtime;
use App\Models\OvertimeEmployee;
use App\Models\Employee;
use Auth;
use Carbon\Carbon;
use DB;

class OvertimeController extends Controller
{
public function index()
{
$overtimes = Overtime::with(['employees.employee.position', 'employees.employee.department'])
                    ->where('status','pending')
                    ->orderBy('date','desc')
                    ->get();

    $grand_total_ot = 0; // tổng tiền OT của tất cả các mảng

    foreach ($overtimes as $ot) {
        $ot->total_ot_amount = 0;

        foreach ($ot->employees as $emp) {
            if ($emp->status != 'manager_declined') {
                $employee = $emp->employee;

                if (!$employee || !$employee->position) {
                    continue; 
                }

                $daily_salary = $employee->position->daily_salary ?? 0;

                $start = strtotime($emp->start_time ?? $ot->start_time);
                $end = strtotime($emp->end_time ?? $ot->end_time);
                $hours = max(0, ($end - $start)/3600);

                $date = $ot->date;
                $isHoliday = \App\Models\Holiday::where('date', $date)->exists();
                $dayOfWeek = date('N', strtotime($date));

             if ($isHoliday) {
    $rate = 3; // ngày lễ 300%
} elseif ($dayOfWeek == 6) {
    $rate = 2; // thứ 7 200%
} elseif ($dayOfWeek == 7) {
    $rate = 3; // chủ nhật 300%
} else {
    $rate = 1.5; // ngày thường 150%
}

                $ot_amount = ($daily_salary / 8) * $hours * $rate;

                $emp->ot_amount = $ot_amount;
                $ot->total_ot_amount += $ot_amount;
            }
        }

        $grand_total_ot += $ot->total_ot_amount; // cộng dồn tổng
    }

    return view('admin.overtimes.index', compact('overtimes', 'grand_total_ot'));
}



    // Từ chối OT cả mảng
public function decline(Request $request, $id)
{
    $overtime = Overtime::findOrFail($id);

    foreach($overtime->employees as $emp){
        if($emp->status != 'manager_declined'){
            $emp->status = 'declined';
            $emp->save();
        }
    }

    $overtime->status = 'declined';
    $employee = Auth::user()->employee;
    $overtime->approver_id = $employee ? $employee->id : null;
    $overtime->save();

    return redirect()->back()->with('success','OT đã bị từ chối.');
}
public function approve(Request $request, $id)
{
    $overtime = Overtime::findOrFail($id);

    foreach($overtime->employees as $emp){
        if($emp->status != 'manager_declined'){
            $emp->status = 'approved';
            $emp->save();
        }
    }

    $overtime->status = 'approved';
    $employee = Auth::user()->employee;
    $overtime->approver_id = $employee ? $employee->id : null;
    $overtime->save();
    return redirect()->back()->with('success','OT được duyệt.');
}

}
