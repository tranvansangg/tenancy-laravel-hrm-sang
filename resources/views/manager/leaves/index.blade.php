@extends('manager.layouts.app') @section('content') <div class="container">
    <h2>Danh sách đơn nghỉ phép nhân viên trong phòng</h2> @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div> @endif <table class="table table-bordered">
        <thead>
            <tr>
                                <th>Mã nhân viên</th>

                <th>Nhân viên</th>
                <th>Loại nghỉ</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Số ngày</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody> @foreach($leaves as $leave) <tr>
                        <td>{{ $leave->employee->employee_code }}</td>

            <td>{{ $leave->employee->full_name }}</td>
            <td>{{ ucfirst($leave->leave_type) }}</td>
            <td>{{ $leave->start_date }}</td>
            <td>{{ $leave->end_date }}</td>
            <td>{{ $leave->days }}</td>
            <td>{{ ucfirst($leave->status) }}</td>
            <td>
    <a href="{{ route('manager.leaves.show', $leave->id) }}" class="btn btn-info btn-sm">Xem</a>

    @if($leave->status == 'pending')
        {{-- Chỉ hiển thị nút duyệt/từ chối nếu người làm đơn KHÔNG phải là trưởng phòng --}}
        @if($leave->employee->position->name != 'Trưởng phòng')
            <form action="{{ route('manager.leaves.approve', $leave->id) }}" method="POST" style="display:inline-block">
                @csrf
                <input type="hidden" name="status" value="approved">
                <button type="submit" class="btn btn-success btn-sm">Duyệt</button>
            </form>

            <form action="{{ route('manager.leaves.approve', $leave->id) }}" method="POST" style="display:inline-block">
                @csrf
                <input type="hidden" name="status" value="rejected">
                <button type="submit" class="btn btn-danger btn-sm">Từ chối</button>
            </form>
        @endif
    @endif
</td>

        </tr> @endforeach </tbody>
    </table> {{ $leaves->links() }}
</div> @endsection