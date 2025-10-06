
<h1>Chi tiết Payroll: {{ $payroll->employee_name }} ({{ $payroll->employee_code }})</h1>

<ul>
    <li>Tháng: {{ $payroll->month }}/{{ $payroll->year }}</li>
    <li>Ngày công: {{ $payroll->work_days }}</li>
    <li>Lương cơ bản: {{ $payroll->base_salary }}</li>
    <li>Phụ cấp: {{ $payroll->allowance }}</li>
    <li>Thưởng: {{ $payroll->bonus }}</li>
    <li>Khấu trừ: {{ $payroll->deduction }}</li>
    <li>Bảo hiểm: {{ $payroll->insurance }}</li>
    <li><b>Lương thực lĩnh: {{ $payroll->net_salary }}</b></li>
</ul>

<a href="{{ route('admin.payrolls.index') }}">Quay lại danh sách</a>
