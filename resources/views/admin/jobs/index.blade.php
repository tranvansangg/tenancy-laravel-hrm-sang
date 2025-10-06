@extends('admin.layouts.app')

@section('title', 'Quản lý việc làm')

@section('content')
<div class="container mt-4">
    <h1>Quản lý việc làm</h1>
    <a href="{{ route('admin.jobs.create') }}" class="btn btn-success mb-3">+ Tạo việc làm mới</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Tiêu đề</th>
                <th>Mô tả</th>
                <th>Địa điểm</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
            <tr>
                <td>{{ $job->title }}</td>
                <td>{{ Str::limit($job->description, 50) }}</td>
                <td>{{ $job->location }}</td>
                <td>{{ $job->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('admin.jobs.edit', $job->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                    <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $jobs->links() }}
</div>
@endsection
