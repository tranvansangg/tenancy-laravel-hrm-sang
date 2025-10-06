@extends('manager.layouts.app')

@section('content')
<div class="container">
    <h2>Bảng lương của {{ $employee->full_name ?? $employee->name }} (Trưởng phòng)</h2>

    @if($payrolls->isEmpty())
        <p>Chưa có dữ liệu lương.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tháng</th>
                    <th>Năm</th>
                    <th>Lương cơ bản</th>
                    <th>Tổng phụ cấp</th>
                    <th>Tổng thưởng</th>
                    <th>Tổng khấu trừ</th>
                    <th>Tăng ca</th>
                    <th>Bảo hiểm</th>
                    <th>Thực lĩnh</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payrolls as $p)
                    <tr>
                        <td>{{ $p->month }}</td>
                        <td>{{ $p->year }}</td>
                        <td>{{ number_format($p->base_salary, 0, ',', '.') }} đ</td>
                        <td>{{ number_format($p->total_allowance, 0, ',', '.') }} đ</td>
                        <td>{{ number_format($p->total_bonus, 0, ',', '.') }} đ</td>
                        <td>{{ number_format($p->total_deduction, 0, ',', '.') }} đ</td>
                        <td>{{ number_format($p->total_overtime, 0, ',', '.') }} đ</td>
                        <td>{{ number_format($p->total_insurance, 0, ',', '.') }} đ</td>
                        <td><strong>{{ number_format($p->net_salary, 0, ',', '.') }} đ</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
