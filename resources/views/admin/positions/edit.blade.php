@extends('admin.layouts.app')

@section('title', 'Sửa Chức Vụ')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                   Chức Vụ
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

                {{-- Form sửa chức vụ --}}
                <form action="{{ route('admin.positions.update', $position->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Mã chức vụ</label>
                        <input class="form-control" name="code"
                            value="{{ old('code', $position->code) }}"
                            placeholder="Nhập mã chức vụ" required />
                    </div>

                    <div class="form-group">
                        <label>Tên chức vụ</label>
                        <input class="form-control" name="name"
                            value="{{ old('name', $position->name) }}"
                            placeholder="Nhập tên chức vụ" required />
                    </div>

                    <div class="form-group">
                        <label>Lương/ngày</label>
                        <input type="number" step="0.01" class="form-control"
                            name="daily_salary"
                            value="{{ old('daily_salary', $position->daily_salary) }}"
                            placeholder="Nhập lương/ngày" required />
                    </div>

                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea class="form-control" rows="3" name="description"
                            placeholder="Nhập mô tả">{{ old('description', $position->description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Trạng thái</label><br>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="1"
                                {{ old('status', $position->status) == 1 ? 'checked' : '' }}>
                            Hiển thị
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="0"
                                {{ old('status', $position->status) == 0 ? 'checked' : '' }}>
                            Ẩn
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <button type="reset" class="btn btn-default">Làm lại</button>
                    <a href="{{ route('admin.positions.index') }}" class="btn btn-default">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
