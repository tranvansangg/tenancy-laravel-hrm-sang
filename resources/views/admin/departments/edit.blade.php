@extends('admin.layouts.app')

@section('title', 'Sửa Phòng Ban')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Phòng Ban
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

                    {{-- Form sửa phòng ban --}}
                    <form action="{{ route('admin.departments.update', $department->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Mã phòng ban</label>
                            <input class="form-control" name="code" value="{{ old('code', $department->code) }}"
                                placeholder="Nhập mã phòng ban" required />
                        </div>

                        <div class="form-group">
                            <label>Tên phòng ban</label>
                            <input class="form-control" name="name" value="{{ old('name', $department->name) }}"
                                placeholder="Nhập tên phòng ban" required />
                        </div>

                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea class="form-control" rows="3" name="description"
                                placeholder="Nhập mô tả">{{ old('description', $department->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Trạng thái</label><br>
                            <label class="radio-inline">
                                <input type="radio" name="status" value="1" {{ old('status', $department->status) == 1 ? 'checked' : '' }}>
                                Hiển thị
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="status" value="0" {{ old('status', $department->status) == 0 ? 'checked' : '' }}>
                                Ẩn
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>

                        <button type="reset" class="btn btn-default">Làm lại</button>

                        <a href="{{ route('admin.departments.index') }}" class="btn btn-default">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection