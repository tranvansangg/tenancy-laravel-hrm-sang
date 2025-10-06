@extends('manager.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Chi tiết công tác</h3>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-6"><b>Mã công tác:</b> {{ $trip->trip_code }}</div>
                <div class="col-md-6"><b>Nhân viên:</b> {{ $trip->employee->full_name }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><b>Mã nhân viên:</b> {{ $trip->employee->employee_code }}</div>
                <div class="col-md-6"><b>Địa điểm:</b> {{ $trip->location }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><b>Thời gian:</b> {{ \Carbon\Carbon::parse($trip->start_date)->format('d/m/Y') }} → {{ \Carbon\Carbon::parse($trip->end_date)->format('d/m/Y') }}</div>
                <div class="col-md-6"><b>Chi phí dự kiến:</b> {{ number_format($trip->estimated_cost, 0, ',', '.') }} VND</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><b>Chi phí thực tế:</b> {{ $trip->actual_cost ? number_format($trip->actual_cost, 0, ',', '.') : 'Chưa cập nhật' }}</div>
                <div class="col-md-6">
                    <b>Trạng thái:</b> 
                    @if($trip->status === 'pending')
                        <span class="badge bg-warning text-dark">Chờ duyệt</span>
                    @elseif($trip->status === 'approved')
                        <span class="badge bg-success">Đã duyệt</span>
                    @elseif($trip->status === 'rejected')
                        <span class="badge bg-danger">Từ chối</span>
                    @elseif($trip->status === 'completed')
                        <span class="badge bg-info">Hoàn thành</span>
                    @endif
                </div>
            </div>

            <div class="mb-2">
                <b>Mục đích:</b>
                <p>{{ $trip->purpose }}</p>
            </div>

            <div class="mb-2">
                <b>Ghi chú:</b>
                <p>{{ $trip->notes ?? 'Không có' }}</p>
            </div>

            <div class="mb-3">
                <b>Phản hồi từ admin:</b>
                <p>{{ $trip->admin_feedback ?? 'Chưa có' }}</p>
            </div>

            <a href="{{ route('manager.business_trips.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</div>
@endsection
