
<h1>Danh sách khấu trừ</h1>
<a href="{{ route('admin.deductions.create') }}" class="btn btn-primary mb-2">Thêm mới</a>

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
<th>Hành động</th>
</tr>
@foreach($deductions as $index => $d)
<tr>
<td>{{ $index + 1 }}</td>
<td>{{ $d->employee->full_name }}</td>
<td>{{ $d->employee->employee_code }}</td>
<td>{{ $d->type }}</td>
<td>{{ number_format($d->amount) }}</td>
<td>{{ \Carbon\Carbon::parse($d->month)->format('m/Y') }}</td>
<td>
<a href="{{ route('deductions.edit',$d->id) }}" class="btn btn-warning btn-sm">Sửa</a>
<form action="{{ route('deductions.destroy',$d->id) }}" method="POST" style="display:inline;">
@csrf
@method('DELETE')
<button class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
</form>
</td>
</tr>
@endforeach
</table>

{{ $deductions->links() }}
