@extends('manager.layouts.app')

@section('content')
<div class="container">
    <h2>Sửa đơn nghỉ phép</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form id="leave-form" action="{{ route('manager.leaves.update', $leave->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Loại nghỉ phép</label>
            <select name="leave_type" id="leave_type" class="form-control" required>
                @foreach($leaveTypes as $type)
                    <option value="{{ $type }}" {{ $leave->leave_type == $type ? 'selected' : '' }}>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Ngày bắt đầu</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $leave->start_date }}" required>
        </div>

        <div class="mb-3">
            <label>Ngày kết thúc</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $leave->end_date }}" required>
        </div>

        <div class="mb-3">
            <label>Lý do</label>
            <textarea name="reason" class="form-control" required>{{ $leave->reason }}</textarea>
        </div>

        <div class="mb-3">
            <label>File chứng nhận (PDF/Ảnh)</label>
            <input type="file" name="document" id="document" class="form-control">
            @if($leave->document)
                <small>File hiện tại: <a href="{{ asset('storage/'.$leave->document) }}" target="_blank">Xem</a></small>
            @endif
            <small id="file-note" class="text-muted"></small>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật đơn</button>
    </form>
</div>

<script>
const leaveType = document.getElementById('leave_type');
const startDate = document.getElementById('start_date');
const endDate = document.getElementById('end_date');
const documentInput = document.getElementById('document');
const fileNote = document.getElementById('file-note');

function updateFileRequirement() {
    const type = leaveType.value;
    const start = startDate.value ? new Date(startDate.value) : null;
    const end = endDate.value ? new Date(endDate.value) : null;
    let days = 0;
    if(start && end){
        days = Math.ceil((end - start) / (1000*60*60*24)) + 1;
    }

    if(type === 'sick' || type === 'maternity'){
        documentInput.required = true;
        fileNote.textContent = 'Bắt buộc chọn file cho loại nghỉ này.';
    } else if(type === 'unpaid' && days > 7){
        documentInput.required = true;
        fileNote.textContent = 'Nghỉ không lương >7 ngày phải chọn file.';
    } else {
        documentInput.required = false;
        fileNote.textContent = '';
    }
}

// Gọi khi load trang để set trạng thái ban đầu
updateFileRequirement();

// Event listener
leaveType.addEventListener('change', updateFileRequirement);
startDate.addEventListener('change', updateFileRequirement);
endDate.addEventListener('change', updateFileRequirement);
</script>

@endsection
