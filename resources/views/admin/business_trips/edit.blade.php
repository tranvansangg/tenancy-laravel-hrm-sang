
@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Xử lý đơn công tác</h3>

    <div class="card">
        <div class="card-body">
            <h5>Thông tin công tác</h5>
            <p><b>Mã đơn:</b> {{ $trip->trip_code }}</p>
            <p><b>Nhân viên:</b> {{ $trip->employee->full_name ?? 'N/A' }}</p>
            <p><b>Mã nhân viên:</b> {{ $trip->employee->employee_code }}</p>
            <p><b>Tiêu đề:</b> {{ $trip->title }}</p>
            <p><b>Thời gian:</b> {{ $trip->start_date }} → {{ $trip->end_date }}</p>
            <p><b>Địa điểm:</b> {{ $trip->location }}</p>
            <p><b>Mục đích:</b> {{ $trip->purpose }}</p>
            <p><b>Ghi chú của trưởng phòng:</b> {{ $trip->notes ?? '-' }}</p>
            <p><b>Chi phí dự kiến:</b> {{ number_format($trip->estimated_cost) }} VNĐ</p>
        </div>
    </div>

    <hr>

   <form action="{{ route('admin.business_trips.approve', $trip->id) }}" method="POST" class="d-inline">
    @csrf
    <div class="mb-2">
        <textarea name="admin_feedback" placeholder="Nhập phản hồi nếu muốn..." class="form-control">{{ $trip->admin_feedback }}</textarea>
    </div>
    <button type="submit" class="btn btn-success">Duyệt</button>
</form>

<form action="{{ route('admin.business_trips.reject', $trip->id) }}" method="POST" class="d-inline">
    @csrf
    <div class="mb-2">
        <textarea name="admin_feedback" placeholder="Nhập lý do từ chối..." class="form-control">{{ $trip->admin_feedback }}</textarea>
    </div>
    <button type="submit" class="btn btn-danger">Từ chối</button>
</form>

</div>
@endsection
