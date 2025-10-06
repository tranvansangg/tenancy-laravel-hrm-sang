
@extends('admin.layouts.app')

@section('content')
<div class="container">
 <h2>Danh sách BHXH</h2>
    <a href="{{ route('admin.insurances_records.create') }}" class="btn btn-primary mb-3">+ Thêm mới</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã NV</th>
                <th>Tên nhân viên</th>
                <th>Ngày tham gia</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
            <tr>
                <td>{{ $record->id }}</td>
                <td>{{ $record->employee->employee_code ?? '-' }}</td>
                <td>{{ $record->employee->full_name ?? '-' }}</td>
                <td>{{ $record->participation_date }}</td>
                <td>
                    @if($record->status == 'active')
                        <span class="badge bg-success">Đang tham gia</span>
                    @elseif($record->status == 'inactive')
                        <span class="badge bg-danger">Đã nghỉ</span>
                    @else
                        <span class="badge bg-warning text-dark">Tạm dừng</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.insurances_records.show', $record->id) }}" class="btn btn-info btn-sm">Xem</a>
                    <a href="{{ route('admin.insurances_records.edit', $record->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('admin.insurances_records.destroy', $record->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Xóa bản ghi này?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $records->links() }}
</div>
@endsection
