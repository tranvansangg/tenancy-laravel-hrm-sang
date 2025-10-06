<form action="{{ route('admin.users.store') }}" method="POST">
    @csrf
    <div>
        <label>Chọn nhân viên:</label>
        <select name="employee_id" required>
            <option value="">-- Chọn nhân viên --</option>
            @foreach($employees as $emp)
                <option value="{{ $emp->id }}">{{$emp->employee_code}}--{{ $emp->full_name }} ({{ $emp->email }})</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Quyền hạn:</label>
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="employee">Nhân viên</option>
        </select>
    </div>

    <div>
        <label>Trạng thái:</label>
        <select name="is_active" required>
            <option value="1">Đang hoạt động</option>
            <option value="0">Ngừng hoạt động</option>
        </select>
    </div>

    <button type="submit">Tạo tài khoản</button>
</form>
