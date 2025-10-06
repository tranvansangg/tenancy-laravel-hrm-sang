@extends('employee.layouts.app')

@section('content')
<div class="container">
    <h2>Đơn đăng ký làm ngày lễ của tôi</h2>
    <a href="{{ route('employee.holiday_requests.create') }}" class="btn btn-primary mb-3">Tạo đơn mới</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ngày lễ</th>
                <th>Lý do</th>
                <th>Trạng thái</th>
                <th>Ngày gửi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $req)
                <tr>
                    <td>{{ $req->holiday->date }} - {{ $req->holiday->description }}</td>
                    <td>{{ $req->reason }}</td>
                    <td>
                        @switch($req->status)
                            @case('pending_manager') Chờ trưởng phòng duyệt @break
                            @case('pending_admin') Chờ admin duyệt @break
                            @case('approved') <span class="text-success">Đã duyệt</span> @break
                            @case('rejected_manager') <span class="text-danger">Trưởng phòng từ chối</span> @break
                            @case('rejected') <span class="text-danger">Admin từ chối</span> @break
                        @endswitch
                    </td>
                    <td>{{ $req->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Chưa có đơn nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
