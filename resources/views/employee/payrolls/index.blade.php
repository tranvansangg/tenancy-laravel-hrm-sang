@extends('employee.layouts.app')

@section('content')
<div class="container">
    <h2>Bảng lương cá nhân</h2>

    <form method="GET" action="{{ route('employee.payrolls.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-3">
                <select name="month" class="form-control">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                            Tháng {{ $m }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <select name="year" class="form-control">
                    @for ($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                            Năm {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary" type="submit">Xem</button>
            </div>
        </div>
    </form>

    @if($payroll)
        <table class="table table-bordered">
            <tr><th>Mã Nhân viên</th><td>{{ $employee->employee_code }}</td></tr>
            <tr><th>Nhân viên</th><td>{{ $employee->full_name ?? $employee->name }}</td></tr>
            <tr><th>Tháng/Năm</th><td>{{ $month }}/{{ $year }}</td></tr>
            <tr><th>Số ngày công</th><td>{{ $payroll->work_days }}</td></tr>
            <tr><th>Lương cơ bản</th><td>{{ number_format($payroll->base_salary) }} đ</td></tr>
            <tr><th>Phụ cấp</th><td>{{ number_format($payroll->allowance) }} đ</td></tr>
            <tr><th>Thưởng</th><td>{{ number_format($payroll->bonus) }} đ</td></tr>
            <tr><th>Tăng ca</th><td>{{ number_format($payroll->overtime) }} đ</td></tr>
            <tr><th>Khấu trừ</th><td>{{ number_format($payroll->deduction) }} đ</td></tr>
            <tr><th>Bảo hiểm</th><td>{{ number_format($payroll->insurance) }} đ</td></tr>
            <tr><th>Lương thực lĩnh</th><td><b>{{ number_format($payroll->net_salary) }} đ</b></td></tr>
            @if($payroll->leave_reason)
                <tr><th>Lý do nghỉ</th><td>{{ $payroll->leave_reason }}</td></tr>
            @endif
        </table>
    @else
        <div class="alert alert-warning">
            Chưa có bảng lương cho tháng {{ $month }}/{{ $year }}.
        </div>
    @endif
</div>
@endsection
