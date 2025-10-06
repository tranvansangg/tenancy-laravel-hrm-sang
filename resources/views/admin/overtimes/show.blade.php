@extends('admin.layouts.app')

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
                <b>Trạng thái:</b>
                @if($overtime->status=='pending')
                    <span class="badge bg-warning">Chờ duyệt</span>
                @elseif($overtime->status=='approved')
                    <span class="badge bg-success">Đã duyệt</span>
                @else
                    <span class="badge bg-danger">Từ chối</span>
                @endif
            </p>

            <h5 class="mt-4">Danh sách nhân viên tham gia:</h5>
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Mã NV</th>
                        <th>Tên nhân viên</th>
                        <th>Trạng thái</th>
                        <th>Lý do từ chối</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($overtime->employees as $emp)
                        <tr>
                            <td>{{ $emp->employee_code }}</td>
                            <td>{{ $emp->full_name }}</td>
                            <td>
                                @if($emp->pivot->status=='accepted')
                                    <span class="badge bg-success">Đồng ý</span>
                                @elseif($emp->pivot->status=='declined')
                                    <span class="badge bg-danger">Từ chối</span>
                                @else
                                    <span class="badge bg-secondary">Chưa phản hồi</span>
                                @endif
                            </td>
                            <td>
                                {{ $emp->pivot->decline_reason ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Hành động của Admin --}}
            @if($overtime->status=='pending')
                <div class="mt-4">
                    <form action="{{ route('admin.overtimes.approve',$overtime->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-success">Duyệt toàn bộ OT</button>
                    </form>
                    <form action="{{ route('admin.overtimes.reject',$overtime->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-danger">Từ chối toàn bộ OT</button>
                    </form>
                </div>
            @endif

            <div class="mt-3">
                <a href="{{ route('admin.overtimes.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
            </div>
        </div>
    </div>
</div>
@endsection
