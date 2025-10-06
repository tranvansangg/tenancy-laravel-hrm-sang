<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use Carbon\Carbon;

class UpdateCarryOverLeaves extends Command
{
    protected $signature = 'leaves:update-carry-over';
    protected $description = 'Cập nhật số ngày phép còn lại chuyển sang năm mới cho tất cả nhân viên';

    public function handle()
    {
        $this->info('Bắt đầu cập nhật carry-over cho nhân viên...');

        $employees = Employee::all();
        foreach ($employees as $employee) {
            // Lấy tổng số ngày phép năm đã approve trong năm trước
            $lastYear = Carbon::now()->subYear()->year;
            $usedAnnual = $employee->leaves()
                ->where('leave_type','annual')
                ->where('status','approved')
                ->whereYear('start_date', $lastYear)
                ->sum('days');

            // Số phép năm cơ bản + thâm niên
            $baseAnnual = 12;
            $yearsWorked = Carbon::parse($employee->created_at)->diffInYears(now());
            $seniorityBonus = floor($yearsWorked / 5);
            $totalAnnual = $baseAnnual + $seniorityBonus;

            // Tính số ngày dư -> carry-over tối đa 5 ngày
            $carryOver = max(min($totalAnnual - $usedAnnual,5),0);

            // Lưu vào cột leave_carry_over
            $employee->leave_carry_over = $carryOver;
            $employee->save();

            $this->info("Employee {$employee->full_name}: carry-over = {$carryOver} ngày");
        }

        $this->info('Cập nhật carry-over hoàn tất!');
    }
}
