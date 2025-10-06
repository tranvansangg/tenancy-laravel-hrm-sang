@extends('admin.layouts.app')
@section('content')
<div class="container">
    <h2>Chi tiết công tác</h2>

    <p><b>Mã:</b> {{ $trip->trip_code }}</p>
    <p><b>Nhân viên:</b> {{ $trip->employee->full_name }}</p>
    <p><b>Mã nhân viên:</b> {{ $trip->employee->employee_code }}</p>
    <p><b>Phòng ban:</b> {{ $trip->employee->department->name ?? '-' }}</p>
    <p><b>Thời gian:</b> {{ $trip->start_date }} → {{ $trip->end_date }}</p>
    <p><b>Địa điểm:</b> {{ $trip->location }}</p>
    <p><b>Mục đích:</b> {{ $trip->purpose }}</p>
    <p><b>Chi phí dự kiến:</b> {{ number_format($trip->estimated_cost,0,',','.') }} đ</p>
    <p><b>Trạng thái:</b> {{ $trip->status }}</p>
    <p><b>Phản hồi Admin:</b> {{ $trip->admin_feedback ?? '-' }}</p>

    @if($trip->status == 'pending')
        <form action="{{ route('admin.business_trips.approve',$trip->id) }}" method="POST" class="mb-2">
            @csrf
            <textarea name="admin_feedback" class="form-control mb-2" placeholder="Nhập phản hồi khi duyệt"></textarea>
            <button class="btn btn-success">Duyệt</button>
        </form>

        <form action="{{ route('admin.business_trips.reject',$trip->id) }}" method="POST">
            @csrf
            <textarea name="admin_feedback" class="form-control mb-2" placeholder="Nhập lý do từ chối"></textarea>
            <button class="btn btn-danger">Từ chối</button>
        </form>
    @endif
</div>
@endsection
