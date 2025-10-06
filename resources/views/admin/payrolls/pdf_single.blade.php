<h2>Bảng lương {{ $payroll->employee_name }} ({{ $payroll->employee_code }}) tháng {{ $payroll->month }}/{{ $payroll->year }}</h2>

<table border="1" cellpadding="5">
    <tr><td>Lương cơ bản</td><td>{{ $payroll->base_salary }}</td></tr>
    <tr><td>Phụ cấp</td><td>{{ $payroll->allowance }}</td></tr>
    <tr><td>Thưởng</td><td>{{ $payroll->bonus }}</td></tr>
    <tr><td>Khấu trừ</td><td>{{ $payroll->deduction }}</td></tr>
    <tr><td>Bảo hiểm</td><td>{{ $payroll->insurance }}</td></tr>
    <tr><td>Lương thực lĩnh</td><td>{{ $payroll->net_salary }}</td></tr>
</table>
