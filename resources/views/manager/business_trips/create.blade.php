@extends('manager.layouts.app')

@section('content')

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Tạo công tác mới</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('manager.business_trips.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="employee_id" class="form-label">Nhân viên</label>
<select name="employee_id" class="form-control" required>
    <option value="">-- Chọn nhân viên --</option>
    @foreach($employees as $employee)
        <option value="{{ $employee->id }}">
            {{ $employee->employee_code }} - {{ $employee->full_name }}

            {{-- Nếu có công tác --}}
            @if($employee->businessTrips->isNotEmpty())
                (Đang công tác: 
                    {{ \Carbon\Carbon::parse($employee->businessTrips->first()->start_date)->format('d/m/Y') }}
                    →
                    {{ \Carbon\Carbon::parse($employee->businessTrips->first()->end_date)->format('d/m/Y') }}
                )
            @endif

            {{-- Nếu có nghỉ phép --}}
            @if($employee->leaves->isNotEmpty())
                (Đang nghỉ phép: 
                    {{ \Carbon\Carbon::parse($employee->leaves->first()->start_date)->format('d/m/Y') }}
                    →
                    {{ \Carbon\Carbon::parse($employee->leaves->first()->end_date)->format('d/m/Y') }}
                )
            @endif
        </option>
    @endforeach
</select>


                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Ngày bắt đầu</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">Ngày kết thúc</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Địa điểm</label>
                    <input type="text" name="location" id="location" class="form-control" placeholder="Nhập địa điểm công tác" required>
                </div>

                <div class="mb-3">
                    <label for="purpose" class="form-label">Mục đích</label>
                    <textarea name="purpose" id="purpose" class="form-control" rows="3" placeholder="Nhập mục đích công tác"></textarea>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">Ghi chú</label>
                    <textarea name="notes" id="notes" class="form-control" rows="2" placeholder="Nhập ghi chú nếu có"></textarea>
                </div>

                <div class="mb-3">
                    <label for="estimated_cost" class="form-label">Chi phí dự kiến</label>
                    <input type="number" step="0.01" name="estimated_cost" id="estimated_cost" class="form-control" placeholder="Nhập chi phí dự kiến">
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Tạo công tác</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
