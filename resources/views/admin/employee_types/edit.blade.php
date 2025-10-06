@extends('admin.layouts.app')
@section('title','Sửa Loại Nhân Viên')

@section('content')
<div class="container">
    <h2>Sửa Loại Nhân Viên</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.employee_types.update', $employee_type->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Mã Loại Nhân Viên</label>
            <input type="text" name="code" class="form-control" value="{{ old('code', $employee_type->code) }}" required>
        </div>
        <div class="form-group">
            <label>Tên Loại Nhân Viên</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $employee_type->name) }}" required>
        </div>
        
        <div class="form-group">
            <label>Mô tả</label>
            <textarea name="description" class="form-control">{{ old('description', $employee_type->description) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="{{ route('admin.employee_types.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
