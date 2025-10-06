@extends('manager.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Sửa đơn công tác</h3>
        </div>
        <div class="card-body">
            @if ($trip->status !== 'pending')
                <div class="alert alert-warning">
                    Đơn công tác này đã được <b>admin xử lý</b> ({{ $trip->status }}). 
                    Bạn không thể chỉnh sửa nữa.
                </div>
                <a href="{{ route('manager.business_trips.index') }}" class="btn btn-secondary">Quay lại</a>
            @else
                <form action="{{ route('manager.business_trips.update', $trip->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" name="title" id="title" class="form-control" 
                               value="{{ old('title', $trip->title) }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Ngày bắt đầu</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" 
                                   value="{{ old('start_date', $trip->start_date) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">Ngày kết thúc</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" 
                                   value="{{ old('end_date', $trip->end_date) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Địa điểm</label>
                        <input type="text" name="location" id="location" class="form-control" 
                               value="{{ old('location', $trip->location) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="purpose" class="form-label">Mục đích</label>
                        <textarea name="purpose" id="purpose" rows="3" class="form-control" required>{{ old('purpose', $trip->purpose) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Ghi chú</label>
                        <textarea name="notes" id="notes" rows="2" class="form-control">{{ old('notes', $trip->notes) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="estimated_cost" class="form-label">Chi phí dự kiến</label>
                        <input type="number" name="estimated_cost" id="estimated_cost" class="form-control" 
                               value="{{ old('estimated_cost', $trip->estimated_cost) }}" min="0" placeholder="Nhập chi phí dự kiến">
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="{{ route('manager.business_trips.index') }}" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
