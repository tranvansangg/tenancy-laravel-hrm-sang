@extends('admin.layouts.app')

@section('title', 'Quản lý Liên Hệ')

@section('content')
<div class="container mt-4">
    <h1>Danh sách liên hệ</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Nội dung</th>
                <th>Ngày gửi</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td>{{ $contact->id }}</td>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->phone }}</td>
                <td>{{ $contact->message }}</td>
                <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <!-- Nút Phản hồi -->
                    <a href="{{ route('admin.contacts.reply', $contact->id) }}" class="btn btn-primary btn-sm mb-1">Phản hồi</a>

                    <!-- Nút Xóa -->
                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $contacts->links() }}
</div>
@endsection
