<form action="{{ route('manager.overtimes.store') }}" method="POST">
    @csrf
    <input type="hidden" name="date" value="{{ $date }}">

    <h3>Danh sách nhân viên phòng ban cho ngày {{ $date }}:</h3>

    @if($employees->count() > 0)
        @foreach($employees as $emp)
            <div>
                <input type="checkbox" name="employee_ids[]" value="{{ $emp->id }}">
                {{ $emp->full_name }} (Mã NV: {{ $emp->employee_code }})
            </div>
        @endforeach
    @else
        <p><em>Không có nhân viên nào khả dụng (tất cả đang nghỉ phép).</em></p>
    @endif

    <label>Lý do OT</label>
    <textarea name="reason" required></textarea>

    <label>Giờ bắt đầu</label>
    <input type="time" name="start_time" required>

    <label>Giờ kết thúc</label>
    <input type="time" name="end_time" required>

    <button type="submit">Tạo OT</button>
</form>
