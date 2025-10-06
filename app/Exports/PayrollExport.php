<?php

namespace App\Exports;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PayrollExport implements FromCollection, WithHeadings
{
    protected $month, $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year  = $year;
    }

    public function collection()
    {
        return Payroll::with('employee.position')
            ->where('month', $this->month)
            ->where('year', $this->year)
            ->get()
            ->map(function ($pr) {
                return [
                    'Họ tên'       => $pr->employee->full_name,
                    'Chức vụ'      => $pr->employee->position->name ?? '',
                    'Ngày công'    => $pr->work_days,
                    'Lương cơ bản' => $pr->base_salary,
                    'Phụ cấp'      => $pr->allowance,
                    'Thưởng + OT'  => $pr->bonus,
                    'Khấu trừ'     => $pr->deduction,
                    'Bảo hiểm'     => $pr->insurance,
                    'Thực lĩnh'    => $pr->net_salary,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Họ tên', 'Chức vụ', 'Ngày công', 'Lương cơ bản', 'Phụ cấp', 
            'Thưởng + OT', 'Khấu trừ', 'Bảo hiểm', 'Thực lĩnh'
        ];
    }
}
