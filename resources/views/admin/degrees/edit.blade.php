@extends('admin.layouts.app')

@section('title', 'Sửa Bằng Cấp')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Bằng Cấp
                        <small>Sửa</small>
                    </h1>
                </div>

                <div class="col-lg-7" style="padding-bottom:120px">

                    {{-- Hiển thị lỗi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Lỗi!</strong> Vui lòng kiểm tra lại dữ liệu nhập vào.
                            <ul>
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form sửa bằng cấp --}}
                    <form action="{{ route('admin.degrees.update', $degree->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Mã bằng cấp</label>
                            <input class="form-control" name="code" value="{{ old('code', $degree->code) }}"
                                placeholder="Nhập mã bằng cấp" required />
                        </div>

                        <div class="form-group">
                            <label>Tên bằng cấp</label>
                            <input class="form-control" name="name" value="{{ old('name', $degree->name) }}"
                                placeholder="Nhập tên bằng cấp" required />
                        </div>

                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea class="form-control" rows="3" name="description"
                                placeholder="Nhập mô tả">{{ old('description', $degree->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Trạng thái</label><br>
                            <label class="radio-inline">
                                <input type="radio" name="status" value="1" {{ old('status', $degree->status) == 1 ? 'checked' : '' }}>
                                Hiển thị
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="status" value="0" {{ old('status', $degree->status) == 0 ? 'checked' : '' }}>
                                Ẩn
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <button type="reset" class="btn btn-default">Làm lại</button>
                        <a href="{{ route('admin.degrees.index') }}" class="btn btn-default">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
