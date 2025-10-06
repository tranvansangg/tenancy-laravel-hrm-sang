@extends('admin.layouts.app')

@section('title', 'Sửa Trình Độ')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <h1 class="page-header">Trình Độ <small>Sửa</small></h1>

        <a href="{{ route('admin.education_levels.index') }}" class="btn btn-default mb-3">
            <i class="fa fa-arrow-left"></i> Quay lại
        </a>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="col-lg-7" style="padding-bottom:120px">
            <form action="{{ route('admin.education_levels.update', $educationLevel->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Mã Trình Độ</label>
                    <input type="text" name="code" class="form-control" value="{{ old('code', $educationLevel->code) }}" required>
                </div>

                <div class="form-group">
                    <label>Tên Trình Độ</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $educationLevel->name) }}" required>
                </div>

                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea name="description" class="form-control">{{ old('description', $educationLevel->description) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('admin.education_levels.index') }}" class="btn btn-default">Hủy</a>
            </form>
        </div>
    </div>
</div>
@endsection
