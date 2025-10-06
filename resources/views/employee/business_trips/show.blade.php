@extends('employee.layouts.app')

@section('content')
<div class="container">
    <h2>Chi tiết công tác</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Mã công tác:</strong> {{ $trip->trip_code }}</p>
            <p><strong>Nhân viên:</strong> {{ $trip->employee->full_name }}</p>
            <p><strong>mã nhân viên:</strong> {{ $trip->employee->employee_code }}</p>
            <p><strong>Ngày bắt đầu:</strong> {{ $trip->start_date }}</p>
            <p><strong>Ngày kết thúc:</strong> {{ $trip->end_date }}</p>
            <p><strong>Địa điểm:</strong> {{ $trip->location }}</p>
            <p><strong>Mục đích:</strong> {{ $trip->purpose ?? '-' }}</p>
            <p><strong>Ghi chú:</strong> {{ $trip->notes ?? '-' }}</p>
            <p><strong>Chi phí dự kiến:</strong> {{ number_format($trip->estimated_cost, 2) }} VND</p>
            <p><strong>Phản hồi admin:</strong> {{ $trip->admin_feedback ?? 'Chưa có phản hồi' }}</p>
        </div>
    </div>

    <a href="{{ route('employee.dashboard') }}" class="btn btn-secondary mt-3">Quay lại</a>
</div>
@endsection
