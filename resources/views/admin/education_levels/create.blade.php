@extends('admin.layouts.app')

@section('title', 'Thêm Trình Độ')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <h1 class="page-header">Trình Độ <small>Thêm Mới</small></h1>

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
            <form action="{{ route('admin.education_levels.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Mã Trình Độ</label>
                    <input type="text" name="code" class="form-control" value="{{ old('code') }}" required>
                </div>

                <div class="form-group">
                    <label>Tên Trình Độ</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Thêm mới</button>
                <button type="reset" class="btn btn-default">Nhập lại</button>
            </form>
        </div>
    </div>
</div>
@endsection
