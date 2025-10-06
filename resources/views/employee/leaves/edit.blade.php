@extends('employee.layouts.app')

@section('content')
<div class="container">
    <h2>Chỉnh sửa đơn nghỉ phép</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form id="leave-form" action="{{ route('employee.leaves.update', $leave->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Loại nghỉ phép</label>
            <select name="leave_type" id="leave_type" class="form-control" required>
                @foreach($leaveTypes as $type)
                    <option value="{{ $type }}" @if($leave->leave_type == $type) selected @endif>
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
            <label>File chứng nhận cơ quan có thẩm quyền (PDF/Ảnh) <small>*Bắt buộc nếu nghỉ ốm, thai sản hoặc nghỉ không lương >7 ngày</small></label>
            @if($leave->document)
                <p>File hiện tại: <a href="{{ asset('storage/'.$leave->document) }}" target="_blank">Xem file</a></p>
            @endif
            <input type="file" name="document" id="document" class="form-control">
            <small id="file-note" class="text-muted"></small>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật đơn</button>
    </form>

    <hr>
    <h4>Nội quy nghỉ phép</h4>

    <ul>
        <li>Nghỉ phép năm: {{ $remainingAnnualLeave }} ngày còn lại trong năm</li>
        @if(in_array('sick', $leaveTypes))
            <li>Nghỉ ốm: <span id="sick-days"></span> ngày/năm theo BHXH</li>
        @endif
        @if(in_array('maternity', $leaveTypes))
            <li>Nghỉ thai sản: tối đa 180 ngày</li>
        @endif
        <li>Nghỉ không lương: nếu >7 ngày, cần file chứng nhận cơ quan có thẩm quyền</li>
    </ul>
</div>

@if(in_array('sick', $leaveTypes))
<script>
    document.getElementById('sick-days').innerText = @json($sickMaxDays);

    const leaveType = document.getElementById('leave_type');
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    const documentInput = document.getElementById('document');
    const fileNote = document.getElementById('file-note');

    function updateFileRequirement() {
        const type = leaveType.value;
        const start = new Date(startDate.value);
        const end = new Date(endDate.value);
        let days = 0;
        if (start && end) {
            days = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
        }

        if(type === 'sick' || type === 'maternity') {
            documentInput.required = true;
            fileNote.textContent = 'Bắt buộc chọn file cho loại nghỉ này.';
        } else if(type === 'unpaid' && days > 7) {
            documentInput.required = true;
            fileNote.textContent = 'Nghỉ không lương >7 ngày phải chọn file.';
        } else {
            documentInput.required = false;
            fileNote.textContent = '';
        }
    }

    leaveType.addEventListener('change', updateFileRequirement);
    startDate.addEventListener('change', updateFileRequirement);
    endDate.addEventListener('change', updateFileRequirement);

    updateFileRequirement(); // chạy khi load trang
</script>
@endif
@endsection
