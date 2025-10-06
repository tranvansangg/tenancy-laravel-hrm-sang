@extends('employee.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Chi tiết Lệnh OT #{{ $overtime->id }}</h4>
        </div>
        <div class="card-body">
            <p><b>Phòng:</b> {{ $overtime->department->name }}</p>
            <p><b>Người tạo:</b> {{ $overtime->creator->full_name }}</p>
            <p><b>Lý do:</b> {{ $overtime->reason }}</p>
            <p><b>Ngày:</b> {{ $overtime->date }}</p>
            <p><b>Giờ:</b> {{ $overtime->start_time }} - {{ $overtime->end_time }}</p>
            <p>
                <b>Trạng thái chung:</b>
                @if($overtime->status=='pending')
                    <span class="badge bg-warning">Chờ duyệt</span>
                @elseif($overtime->status=='approved')
                    <span class="badge bg-success">Đã duyệt</span>
                @else
                    <span class="badge bg-danger">Từ chối</span>
                @endif
            </p>

            <h5 class="mt-4">Trạng thái của tôi:</h5>
            @php
                $pivot = $overtime->employees->first()->pivot ?? null;
            @endphp
            <p>
                @if($pivot?->status == 'accepted')
                    <span class="badge bg-success">Đồng ý</span>
                @elseif($pivot?->status == 'declined')
                    <span class="badge bg-danger">Từ chối</span>
                    <br>Lý do: {{ $pivot->decline_reason }}
                @else
                    <span class="badge bg-secondary">Chưa phản hồi</span>
                @endif
            </p>

            {{-- Nếu chưa phản hồi thì hiển thị form --}}
            @if($pivot?->status == null)
                <div class="mt-3">
                    <form action="{{ route('employee.overtimes.accept',$overtime->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-success">Đồng ý OT</button>
                    </form>

                    <form action="{{ route('employee.overtimes.reject',$overtime->id) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="text" name="decline_reason" placeholder="Lý do từ chối" required class="form-control d-inline-block w-auto me-2">
                        <button class="btn btn-danger">Từ chối OT</button>
                    </form>
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('employee.overtimes.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
            </div>
        </div>
    </div>
</div>
@endsection
