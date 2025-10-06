@extends('employee.layouts.app')

@section('content')
<div class="container">
    <h2>Tạo đơn đăng ký làm ngày lễ</h2>

    <form method="POST" action="{{ route('employee.holiday_requests.store') }}">
        @csrf
        <div class="form-group mb-3">
            <label>Ngày lễ</label>
            <select name="holiday_id" class="form-control" required>
                @foreach($holidays as $holiday)
                    <option value="{{ $holiday->id }}">
                        {{ $holiday->date }} - {{ $holiday->description }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-3">
            <label>Lý do</label>
            <input type="text" name="reason" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Gửi yêu cầu</button>
    </form>
</div>
@endsection
