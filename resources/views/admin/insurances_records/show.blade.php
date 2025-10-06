@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Chi tiết BHXH</h2>

    <table class="table table-bordered">
        <tr>
            <th>Mã NV</th>
            <td>{{ $record->employee->employee_code }}</td>
        </tr>
        <tr>
            <th>Tên nhân viên</th>
            <td>{{ $record->employee->name }}</td>
        </tr>
        <tr>
            <th>Ngày tham gia</th>
            <td>{{ $record->participation_date }}</td>
        </tr>
        <tr>
            <th>Trạng thái</th>
            <td>
                @if($record->status == 'active')
                    <span class="badge bg-success">Đang tham gia</span>
                @elseif($record->status == 'inactive')
                    <span class="badge bg-danger">Đã nghỉ</span>
                @else
                    <span class="badge bg-warning text-dark">Tạm dừng</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>Số BHXH</th>
            <td>{{ $record->social_insurance_number ?? '-' }}</td>
        </tr>
        <tr>
            <th>Số BHYT</th>
            <td>{{ $record->health_insurance_number ?? '-' }}</td>
        </tr>
        <tr>
            <th>Số BHTN</th>
            <td>{{ $record->unemployment_insurance_number ?? '-' }}</td>
        </tr>
        <tr>
            <th>Ghi chú</th>
            <td>{{ $record->notes ?? '-' }}</td>
        </tr>
    </table>

    <a href="{{ route('admin.insurances_records.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection
