@extends('manager.layouts.app')

@section('content')
<div class="container">
    <h2>Chi tiết đơn nghỉ phép</h2>

    <p><strong>Nhân viên:</strong> {{ $leave->employee->name }}</p>
    <p><strong>Mã nhân viên:</strong> {{ $leave->employee->employee_code }}</p>
    <p><strong>Loại nghỉ:</strong> {{ ucfirst($leave->leave_type) }}</p>
    <p><strong>Ngày bắt đầu:</strong> {{ $leave->start_date }}</p>
    <p><strong>Ngày kết thúc:</strong> {{ $leave->end_date }}</p>
    <p><strong>Số ngày:</strong> {{ $leave->days }}</p>
    <p><strong>Lý do:</strong> {{ $leave->reason }}</p>
    @if($leave->document)
        <p><strong>File:</strong> <a href="{{ asset('storage/'.$leave->document) }}" target="_blank">Xem file</a></p>
    @endif

    @if($leave->status == 'pending')
    <hr>
    <h4>Duyệt/Từ chối đơn</h4>
    <form action="{{ route('manager.leaves.approve', $leave->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="status" class="form-control" required>
                <option value="approved">Duyệt</option>
                <option value="rejected">Từ chối</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Ghi chú phản hồi</label>
            <textarea name="manager_note" class="form-control" rows="3">{{ old('manager_note', $leave->manager_note) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
    @else
        <p><strong>Trạng thái:</strong> {{ ucfirst($leave->status) }}</p>
        @if($leave->manager_note)
            <p><strong>Phản hồi trưởng phòng:</strong> {{ $leave->manager_note }}</p>
        @endif
    @endif
</div>
@endsection
