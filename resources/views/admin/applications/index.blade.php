@extends('admin.layouts.app')

@section('title', 'Quản lý ứng viên')

@section('content')
<div class="container mt-4">
    <h1>Danh sách CV ứng tuyển</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Ứng viên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Ứng tuyển vị trí</th>
                <th>CV</th>
                <th>Ngày nộp</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $app)
            <tr>
                <td>{{ $app->applicant_name }}</td>
                <td>{{ $app->email }}</td>
                <td>{{ $app->phone }}</td>
                <td>{{ $app->job->title }}</td>
                <td><a href="{{ asset('storage/'.$app->cv_file) }}" target="_blank">Xem CV</a></td>
                <td>{{ $app->created_at->format('d/m/Y') }}</td>
                <td>
                    <form action="{{ route('admin.applications.destroy', $app->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa CV này?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $applications->links() }}
</div>
@endsection
