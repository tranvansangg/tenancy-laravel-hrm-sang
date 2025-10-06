@extends('admin.layouts.app')

@section('title', 'Sửa việc làm')

@section('content')
<div class="container mt-4">
    <h1>Sửa việc làm</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề việc làm</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $job->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả công việc</label>
            <textarea class="form-control" id="description" name="description" rows="6">{{ old('description', $job->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Địa điểm (nếu có)</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $job->location) }}">
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
</script>
@endsection
