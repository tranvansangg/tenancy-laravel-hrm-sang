@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Duyệt / Cập nhật đơn nghỉ phép</h2>

    <form action="{{ route('admin.leaves.update', $leave->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nhân viên</label>
            <input type="text" class="form-control" value="{{ $leave->employee->full_name }}" disabled>
        </div>
        <div class="mb-3">
            <label>Mã nhân viên</label>
            <input type="text" class="form-control" value="{{ $leave->employee->employee_code }}" disabled>
        </div>

        <div class="mb-3">
            <label>Loại nghỉ</label>
            <input type="text" class="form-control" value="{{ ucfirst($leave->leave_type) }}" disabled>
        </div>

        <div class="mb-3">
            <label>Từ ngày</label>
            <input type="date" class="form-control" value="{{ $leave->start_date }}" disabled>
        </div>

        <div class="mb-3">
            <label>Đến ngày</label>
            <input type="date" class="form-control" value="{{ $leave->end_date }}" disabled>
        </div>

        <div class="mb-3">
            <label>Lý do</label>
            <textarea class="form-control" disabled>{{ $leave->reason }}</textarea>
        </div>

        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="status" class="form-control">
                <option value="pending" {{ $leave->status=='pending'?'selected':'' }}>Chờ duyệt</option>
                <option value="approved" {{ $leave->status=='approved'?'selected':'' }}>Duyệt</option>
                <option value="rejected" {{ $leave->status=='rejected'?'selected':'' }}>Từ chối</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Phản hồi cho nhân viên</label>
            <textarea name="admin_note" class="form-control">{{ old('admin_note', $leave->admin_note) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('admin.leaves.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
