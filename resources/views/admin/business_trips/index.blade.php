@extends('admin.layouts.app')
@section('content')
<div class="container">
    <h2>Danh sách công tác</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã</th>
                <th>Nhân viên</th>
                <th>Mã nhân viên</th>
                <th>Phòng ban</th>
                <th>Thời gian</th>
                <th>Địa điểm</th>
                <th>Trạng thái</th>
                <th>Phản hồi</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trips as $trip)
                <tr>
                    <td>{{ $trip->trip_code }}</td>
                    <td>{{ $trip->employee->full_name }}</td>
                    <td>{{ $trip->employee->employee_code }}</td>
                    <td>{{ $trip->employee->department->name ?? '-' }}</td>
                    <td>{{ $trip->start_date }} → {{ $trip->end_date }}</td>
                    <td>{{ $trip->location }}</td>
                    <td>
                        @if($trip->status == 'pending')
                            <span class="badge bg-warning">Chờ duyệt</span>
                        @elseif($trip->status == 'approved')
                            <span class="badge bg-success">Đã duyệt</span>
                        @elseif($trip->status == 'rejected')
                            <span class="badge bg-danger">Từ chối</span>
                        @else
                            <span class="badge bg-info">Hoàn thành</span>
                        @endif
                    </td>
                    <td>{{ $trip->admin_feedback ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.business_trips.show',$trip->id) }}" class="btn btn-sm btn-info">Xem</a>
                        <a href="{{ route('admin.business_trips.edit',$trip->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                        <form action="{{ route('admin.business_trips.destroy',$trip->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa công tác?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $trips->links() }}
</div>
@endsection
