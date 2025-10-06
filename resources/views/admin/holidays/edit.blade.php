@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Sửa ngày lễ</h2>
    <form action="{{ route('admin.holidays.update', $holiday) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Ngày lễ</label>
            <input type="date" name="date" class="form-control" value="{{ $holiday->date }}" required>
        </div>
        <div class="mb-3">
            <label>Mô tả</label>
            <input type="text" name="description" class="form-control" value="{{ $holiday->description }}">
        </div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
</div>
@endsection
