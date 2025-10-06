@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Thêm mới BHXH</h2>

    <form action="{{ route('admin.insurances_records.store') }}" method="POST">
        @csrf
        @include('admin.insurances_records.form', ['record' => null])
        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{ route('admin.insurances_records.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
