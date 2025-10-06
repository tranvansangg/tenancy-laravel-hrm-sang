
<table>
    <thead>
        <tr>
            <th>STT</th>
            <th>Ảnh</th>
            <th>Họ Tên</th>
            <th>Email</th>
            <th>Lượt truy cập</th>
            <th>Quyền hạn</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $key => $user)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>
                @if($user->avatar)
                    <img src="{{ asset('storage/'.$user->avatar) }}" width="50" height="50">
                @else
                    N/A
                @endif
            </td>
            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->access_count }}</td>
            <td>{{ ucfirst($user->role) }}</td>
            <td>{{ $user->is_active ? 'Đang hoạt động' : 'Ngừng hoạt động' }}</td>
            <td>
                <a href="{{ route('admin.users.edit', $user->id) }}">Sửa</a>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $users->links() }}
