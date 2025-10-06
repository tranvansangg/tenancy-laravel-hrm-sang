@extends('manager.layouts.app')

@section('content')
<div class="container">
    <h2>Đơn đăng ký làm ngày lễ - Phòng ban của tôi</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nhân viên</th>
                <th>Mã nhân viên</th>
                <th>Ngày lễ</th>
                <th>Lý do</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $req)
                <tr>
                    <td>{{ $req->employee->full_name }}</td>
                    <td>{{ $req->employee->employee_code }}</td>
                    <td>{{ $req->holiday->date }} - {{ $req->holiday->description }}</td>
                    <td>{{ $req->reason }}</td>
                    <td>{{ $req->status }}</td>
                    <td>
                        <form method="POST" action="{{ route('manager.holiday_requests.approve', $req->id) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm">Duyệt</button>
                        </form>
                        <form method="POST" action="{{ route('manager.holiday_requests.reject', $req->id) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-danger btn-sm">Từ chối</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Không có đơn nào cần duyệt.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
