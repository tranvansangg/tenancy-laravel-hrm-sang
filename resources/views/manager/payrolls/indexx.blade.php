@extends('manager.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Bảng Lương Tháng {{ $month }}/{{ $year }}</h1>

    <div class="mb-3">
        <a href="{{ route('manager.payrolls.generate', ['month' => $month, 'year' => $year]) }}" class="btn btn-primary">
            Tính lương toàn công ty
        </a>
        <a href="{{ route('manager.payrolls.export', ['month' => $month, 'year' => $year]) }}" class="btn btn-success">
            Xuất Excel
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nhân viên</th>
                <th>Chức vụ</th>
                <th>Số công</th>
                <th>Lương cơ bản</th>
                <th>Phụ cấp</th>
                <th>Thưởng + OT</th>
                <th>Khấu trừ</th>
                <th>Bảo hiểm</th>
                <th>Thực lĩnh</th>
                <th>Lý Không lương thực lĩnh 0đ (nếu có)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payrolls as $payroll)
                <tr>
                    <td>{{ $payroll->employee->full_name }}</td>
                    <td>{{ $payroll->employee->position->name ?? '-' }}</td>
                    <td>{{ $payroll->work_days }}</td>
                    <td>{{ number_format($payroll->base_salary) }}</td>
                    <td>{{ number_format($payroll->allowance) }}</td>
                    <td>{{ number_format(($payroll->bonus ?? 0) + ($payroll->overtime ?? 0)) }}</td>
                    <td>{{ number_format($payroll->deduction) }}</td>
                    <td>{{ number_format($payroll->insurance) }}</td>
                    <td>
                        @if($payroll->net_salary > 0)
                            <span class="text-success">{{ number_format($payroll->net_salary) }}</span>
                        @else
                            <span class="text-danger">0</span>
                        @endif
                    </td>
                    <td>
                        @if($payroll->net_salary <= 0 && $payroll->leave_reason)
                            <span class="text-muted">{{ $payroll->leave_reason }}</span>
                        @else
                            -
                        @endif
                    </td>
                   
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Phân trang --}}
    <div class="mt-3">
        {{ $payrolls->links() }}
    </div>
</div>
@endsection
