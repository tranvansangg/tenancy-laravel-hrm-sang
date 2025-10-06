@extends('employee.layouts.app')

@section('content')
<div class="container">
    <h2>Chi tiết đơn nghỉ phép</h2>

    <table class="table table-bordered">
        <tr>
            <th>Loại nghỉ</th>
            <td>{{ ucfirst($leave->leave_type) }}</td>
        </tr>
        <tr>
            <th>Ngày bắt đầu</th>
            <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Ngày kết thúc</th>
            <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Số ngày</th>
            <td>{{ $leave->days }}</td>
        </tr>
        <tr>
            <th>Trạng thái</th>
            <td>{{ ucfirst($leave->status) }}</td>
        </tr>
        <tr>
            <th>Nghỉ có lương</th>
            <td>{{ $leave->is_paid ? 'Có' : 'Không' }}</td>
        </tr>
        <tr>
            <th>Lý do</th>
            <td>{{ $leave->reason }}</td>
        </tr>
        <tr>
            <th>File chứng nhận</th>
            <td>
                @if($leave->document)
                    <a href="{{ asset('storage/' . $leave->document) }}" target="_blank">Xem file</a> |
                    <a href="{{ asset('storage/' . $leave->document) }}" download>Tải xuống</a>
                @else
                    Không có
                @endif
            </td>
        </tr>
    </table>

    <a href="{{ route('employee.leaves.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection
