@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Thêm ngày lễ</h2>
    <form action="{{ route('admin.holidays.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Ngày lễ</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mô tả</label>
            <input type="text" name="description" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
</div>
@endsection
