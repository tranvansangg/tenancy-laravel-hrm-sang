@extends('manager.layouts.app')

@section('content')
<div class="container">
    <h2>Đăng ký làm việc ngày lễ</h2>

    <form action="{{ route('manager.holiday_requests.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="holiday_id" class="form-label">Ngày lễ</label>
            <select name="holiday_id" id="holiday_id" class="form-select" required>
                <option value="">-- Chọn ngày lễ --</option>
                @foreach($holidays as $holiday)
                    <option value="{{ $holiday->id }}">{{ $holiday->date }} - {{ $holiday->description }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="reason" class="form-label">Lý do (không bắt buộc)</label>
            <textarea name="reason" id="reason" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
        <a href="{{ route('manager.holiday_requests.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
