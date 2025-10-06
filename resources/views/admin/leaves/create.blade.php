@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Xin nghỉ phép</h2>

    <div id="alert"></div>

    <form id="leaveForm">
        @csrf

        <label>Loại nghỉ:</label>
        <select name="leave_type" id="leave_type" required>
            @foreach($leaveTypes as $type)
                <option value="{{ $type }}">
                    {{ ucfirst($type) }}
                    @if($type=='annual') ({{ $remainingAnnualLeave }} ngày còn lại) @endif
                </option>
            @endforeach
        </select>

        <label>Ngày bắt đầu:</label>
        <input type="date" name="start_date" id="start_date" required>

        <label>Ngày kết thúc:</label>
        <input type="date" name="end_date" id="end_date" required>

        <label>Lý do (tùy chọn):</label>
        <textarea name="reason" id="reason"></textarea>

        <button type="submit" class="btn btn-primary">Gửi đơn</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('leaveForm').addEventListener('submit', function(e){
    e.preventDefault();

    let formData = new FormData(this);

    fetch("{{ route('admin.leaves.store', $employee->id) }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept':'application/json'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            document.getElementById('alert').innerHTML = `<div class="alert alert-success">${data.success}</div>`;
            // ẩn annual leave nếu gửi thành công
            if(formData.get('leave_type')=='annual'){
                document.querySelector('#leave_type option[value="annual"]').remove();
            }
        } else if(data.error){
            document.getElementById('alert').innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
        }
    })
    .catch(err => console.log(err));
});
</script>
@endsection
