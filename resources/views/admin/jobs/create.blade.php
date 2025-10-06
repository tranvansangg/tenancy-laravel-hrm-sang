@extends('admin.layouts.app')

@section('title', 'Tạo việc làm mới')

@section('content')
<div class="container mt-4">
    <h1>Tạo việc làm mới</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.jobs.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề việc làm</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả công việc</label>
            <textarea class="form-control" id="description" name="description" rows="6">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Địa điểm (nếu có)</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}">
        </div>

        <button type="submit" class="btn btn-success">Tạo việc làm</button>
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection

@section('scripts')
<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
</script>
@endsection
