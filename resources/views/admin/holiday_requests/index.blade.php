@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Danh sách đơn đăng ký làm ngày lễ</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã nhân viên</th>
                <th>Nhân viên</th>
                <th>Phòng ban</th>
                <th>Ngày lễ</th>
                <th>Lý do</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $req)
                <tr>
                    <td>{{ $req->employee->employee_code }}</td>
                    <td>{{ $req->employee->full_name }}</td>
                    <td>{{ $req->department->name }}</td>
                    <td>{{ $req->holiday->date }} - {{ $req->holiday->description }}</td>
                    <td>{{ $req->reason }}</td>
                    <td>{{ $req->status }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.holiday_requests.approve', $req->id) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm">Duyệt</button>
                        </form>
                        <form method="POST" action="{{ route('admin.holiday_requests.reject', $req->id) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-danger btn-sm">Từ chối</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">Không có đơn nào cần duyệt.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
