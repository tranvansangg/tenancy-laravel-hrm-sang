@extends('admin.layouts.app')
@section('title','Thêm Loại Nhân Viên')

@section('content')

<div class="container">
    <h2>Thêm Loại Nhân Viên</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.employee_types.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Mã Loại Nhân Viên</label>
            <input type="text" name="code" class="form-control" value="{{ old('code') }}" required>
        </div>
        <div class="form-group">
            <label>Tên Loại Nhân Viên</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        
        <div class="form-group">
            <label>Mô tả</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="{{ route('admin.employee_types.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
