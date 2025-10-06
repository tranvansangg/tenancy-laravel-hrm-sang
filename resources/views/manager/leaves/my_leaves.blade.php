@extends('manager.layouts.app')

@section('content')
<div class="container">
    <h2>Đơn nghỉ phép của tôi</h2>

    <a href="{{ route('manager.leaves.create') }}" class="btn btn-primary mb-3">Tạo đơn mới</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Loại nghỉ</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Số ngày</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leaves as $leave)
                <tr>
                    <td>{{ ucfirst($leave->leave_type) }}</td>
                    <td>{{ $leave->start_date }}</td>
                    <td>{{ $leave->end_date }}</td>
                    <td>{{ $leave->days }}</td>
                    <td>{{ ucfirst($leave->status) }}</td>
                    <td>
                        <a href="{{ route('manager.leaves.show', $leave->id) }}" class="btn btn-info btn-sm">Xem</a>
                        @if($leave->status=='pending')
                            <a href="{{ route('manager.leaves.edit', $leave->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $leaves->links() }}
</div>
@endsection
