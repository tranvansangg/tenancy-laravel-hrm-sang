
<form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label>Ảnh:</label>
        <input type="file" name="avatar">
        @if($user->avatar)
            <img src="{{ asset('storage/'.$user->avatar) }}" width="50">
        @endif
    </div>
    <div>
        <label>Họ:</label>
        <input type="text" name="first_name" value="{{ $user->first_name }}" required>
    </div>
  
    <div>
        <label>Email:</label>
        <input type="email" name="email" value="{{ $user->email }}" required>
    </div>
    <div>
        <label>Số điện thoại:</label>
        <input type="text" name="phone" value="{{ $user->phone }}">
    </div>
    <div>
        <label>Quyền hạn:</label>
        <select name="role" required>
            <option value="admin" @if($user->role=='admin') selected @endif>Admin</option>
            <option value="manager" @if($user->role=='manager') selected @endif>Trưởng phòng</option>
            <option value="employee" @if($user->role=='employee') selected @endif>Nhân viên</option>
        </select>
    </div>
    <div>
        <label>Trạng thái:</label>
        <select name="is_active" required>
            <option value="1" @if($user->is_active) selected @endif>Đang hoạt động</option>
            <option value="0" @if(!$user->is_active) selected @endif>Ngừng hoạt động</option>
        </select>
    </div>
    <button type="submit">Cập nhật</button>
</form>
