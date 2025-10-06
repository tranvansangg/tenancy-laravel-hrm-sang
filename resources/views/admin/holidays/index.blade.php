@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Danh sách ngày lễ</h2>
    <a href="{{ route('admin.holidays.create') }}" class="btn btn-primary mb-3">+ Thêm ngày lễ</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ngày</th>
                <th>Mô tả</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($holidays as $holiday)
                <tr>
                    <td>{{ $holiday->date }}</td>
                    <td>{{ $holiday->description }}</td>
                    <td>
                        <a href="{{ route('admin.holidays.edit', $holiday) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('admin.holidays.destroy', $holiday) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
