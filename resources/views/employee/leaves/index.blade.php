@extends('employee.layouts.app')

@section('content')
<div class="container">
    <h2>Danh sách đơn nghỉ phép</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Loại nghỉ</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Số ngày</th>
                <th>Trạng thái</th>
                <th>Có lương</th>
                <th>Lý do</th>
                <th>File chứng nhận</th>
                <th>Xem</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaves as $leave)
                <tr>
                    <td>{{ ucfirst($leave->leave_type) }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d/m/Y') }}</td>
                    <td>{{ $leave->days }}</td>
                    <td>{{ ucfirst($leave->status) }}</td>
                    <td>{{ $leave->is_paid ? 'Có' : 'Không' }}</td>
                    <td>{{ $leave->reason }}</td>
                    <td>
                        @if($leave->document)
                            <a href="{{ asset('storage/'.$leave->document) }}" target="_blank">Xem file</a>
                        @else
                            Không có
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('employee.leaves.show', $leave->id) }}" class="btn btn-info btn-sm">Xem</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Chưa có đơn nghỉ phép</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $leaves->links() }}
</div>
@endsection
