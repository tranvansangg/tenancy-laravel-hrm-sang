@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Cập nhật BHXH</h2>

    <form action="{{ route('admin.insurances_records.update', $record->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.insurances_records.form', ['record' => $record])
        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('admin.insurances_records.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
