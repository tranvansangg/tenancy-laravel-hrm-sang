<h2>Bảng lương toàn bộ tháng {{ $month }}</h2>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>Mã NV</th>
            <th>Tên NV</th>
            <th>Lương thực lĩnh</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payrolls as $payroll)
            @if($payroll->employee->status=='active')
            <tr>
                <td>{{ $payroll->employee_code }}</td>
                <td>{{ $payroll->employee_name }}</td>
                <td>{{ $payroll->net_salary }}</td>
            </tr>
            @endif
        @endforeach
    </tbody>
</table>
