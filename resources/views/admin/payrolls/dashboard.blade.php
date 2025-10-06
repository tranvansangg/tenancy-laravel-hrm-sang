@extends('layouts.admin')

@section('content')
<h1>Dashboard Payroll</h1>
<p>Tháng: {{ $month }}/{{ $year }}</p>

<ul>
    <li>Tổng nhân viên: {{ $totalEmployees }}</li>
    <li>Tổng lương cơ bản: {{ $totalBaseSalary }}</li>
    <li>Tổng phụ cấp: {{ $totalAllowance }}</li>
    <li>Tổng lương thực lĩnh: {{ $totalNetSalary }}</li>
</ul>

<canvas id="payrollChart" width="400" height="200"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('payrollChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! $payrolls->pluck('employee.name') !!},
        datasets: [{
            label: 'Lương thực lĩnh',
            data: {!! $payrolls->pluck('net_salary') !!},
            backgroundColor: 'rgba(54, 162, 235, 0.6)'
        }]
    }
});
</script>
@endsection
