
<h1>Danh sách phụ cấp</h1>
<a href="{{ route('admin.allowances.create') }}" class="btn btn-primary mb-2">Thêm mới</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
<tr>
<th>#</th>
<th>Nhân viên</th>
<th>Loại</th>
<th>Số tiền</th>
<th>Tháng</th>
<th>Hành động</th>
</tr>
@foreach($allowances as $index => $a)
<tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $a->employee->full_name }}</td>
    <td>{{ $a->type }}</td>
    <td>{{ number_format($a->amount) }}</td>
    <td>{{ \Carbon\Carbon::parse($a->month)->format('Y-m') }}</td>
    <td>
        <!-- Nút chỉnh sửa/xóa -->
        <a href="{{ route('admin.allowances.edit', $a->id) }}" class="btn btn-sm btn-primary">Sửa</a>
        <form action="{{ route('admin.allowances.destroy', $a->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
        </form>
    </td>
</tr>

@endforeach
</table>

{{ $allowances->links() }}
