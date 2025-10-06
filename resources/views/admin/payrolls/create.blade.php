
<h1>Tạo bảng lương</h1>

<form action="{{ route('admin.payrolls.store') }}" method="POST">
    @csrf

    {{-- Chọn nhân viên riêng lẻ --}}
    <div>
        <label>Chọn nhân viên:</label>
        <select name="employee_id">
            <option value="">-- Chọn nhân viên --</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}">
                    {{ $employee->employee_code }} - {{ $employee->full_name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Chọn từ ngày → đến ngày --}}
    <div style="margin-top:10px;">
        <label>Từ ngày:</label>
        <input type="date" name="start_date" required>
    </div>

    <div style="margin-top:10px;">
        <label>Đến ngày:</label>
        <input type="date" name="end_date" required>
    </div>

    {{-- Tùy chọn tạo cho tất cả nhân viên active --}}
    <div style="margin-top:10px;">
        <label>
            <input type="checkbox" name="create_all" value="1">
            Tạo bảng lương cho tất cả nhân viên đang hoạt động
        </label>
    </div>

    <button type="submit" style="margin-top:10px;">Tạo bảng lương</button>
</form>
