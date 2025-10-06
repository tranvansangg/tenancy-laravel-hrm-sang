@extends('admin.layouts.app')
@section('title','Sửa Chuyên Môn')

@section('content')
<div class="container">
    <h2>Sửa Chuyên môn</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.specialties.update', $specialty->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Mã Chuyên môn</label>
            <input type="text" name="code" class="form-control" value="{{ old('code', $specialty->code) }}" required>
        </div>
        <div class="form-group">
            <label>Tên Chuyên môn</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $specialty->name) }}" required>
        </div>
        <div class="form-group">
            <label>Mô tả</label>
            <textarea name="description" class="form-control">{{ old('description', $specialty->description) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="{{ route('admin.specialties.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
