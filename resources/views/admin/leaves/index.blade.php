@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Danh sách đơn nghỉ phép</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nhân viên</th>
                <th>Mã nhân viên</th>
                <th>chức vụ</th>
                <th>Loại nghỉ</th>
                <th>Từ ngày</th>
                <th>Đến ngày</th>
                <th>Số ngày</th>
                <th>Lý do</th>
                <th>Trạng thái</th>
                <th>Phản hồi</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaves as $leave)
                <tr>
                    <td>{{ $loop->iteration + ($leaves->currentPage()-1)*$leaves->perPage() }}</td>
                    <td>{{ $leave->employee->full_name ?? '—' }}</td>
                    <td>{{ $leave->employee->employee_code ??   '—' }}</td>
                    <td>{{ $leave->employee->position->name ?? '—' }}</td>

                    <td>{{ ucfirst($leave->leave_type) }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d/m/Y') }}</td>
                    <td>{{ $leave->days }}</td>
                    <td>{{ $leave->reason ?? '—' }}</td>
                    <td>
                        @if($leave->status=='pending')
                            <span class="badge bg-warning">Chờ duyệt</span>
                        @elseif($leave->status=='approved')
                            <span class="badge bg-success">Đã duyệt</span>
                        @elseif($leave->status=='rejected')
                            <span class="badge bg-danger">Từ chối</span>
                        @endif
                    </td>
                    <td>{{ $leave->admin_note ?? '—' }}</td>
                    <td>
                        <a href="{{ route('admin.leaves.edit', $leave->id) }}" class="btn btn-sm btn-primary">Duyệt / Sửa</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Chưa có đơn nghỉ phép nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $leaves->links() }}
</div>
@endsection
