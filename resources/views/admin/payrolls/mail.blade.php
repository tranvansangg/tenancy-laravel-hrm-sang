<h2>Bảng lương tháng {{ $payroll->month }}/{{ $payroll->year }}</h2>
<p>Xin chào {{ $payroll->employee_name }},</p>

<ul>
    <li>Lương cơ bản: {{ $payroll->base_salary }}</li>
    <li>Phụ cấp: {{ $payroll->allowance }}</li>
    <li>Thưởng: {{ $payroll->bonus }}</li>
    <li>Khấu trừ: {{ $payroll->deduction }}</li>
    <li>Bảo hiểm: {{ $payroll->insurance }}</li>
    <li><b>Lương thực lĩnh: {{ $payroll->net_salary }}</b></li>
</ul>

<p>Trân trọng,<br>Phòng nhân sự</p>
