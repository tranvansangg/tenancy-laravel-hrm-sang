
<h1>Danh sách khen thưởng</h1>
<a href="{{ route('admin.bonuses.create') }}" class="btn btn-primary mb-2">Thêm mới</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
<tr>
<th>#</th>
<th>Nhân viên</th>
<th>Mã nhân viên</th>
<th>Loại</th>
<th>Số tiền</th>
<th>Tháng</th>
<th>Ghi chú</th>
<th>Hành động</th>
</tr>
@foreach($bonuses as $index => $b)
<tr>
<td>{{ $index + 1 }}</td>
<td>{{ $b->employee->full_name }}</td>
<td>{{ $b->employee->employee_code }}</td>
<td>{{ $b->type }}</td>
<td>{{ number_format($b->amount) }}</td>
<td>{{ \Carbon\Carbon::parse($b->month)->format('m/Y') }}</td>
<td>{{ $b->notes }}</td>
<td>
<a href="{{ route('admin.bonuses.edit',$b->id) }}" class="btn btn-warning btn-sm">Sửa</a>
<form action="{{ route('admin.bonuses.destroy',$b->id) }}" method="POST" style="display:inline;">
@csrf
@method('DELETE')
<button class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
</form>
</td>
</tr>
@endforeach
</table>

{{ $bonuses->links() }}
