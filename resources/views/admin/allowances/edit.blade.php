
<h1>Sửa phụ cấp</h1>
<form action="{{ route('admin.allowances.update', $allowance->id) }}" method="POST">
@csrf
@method('PUT')
<div class="form-group">
<label>Nhân viên</label>
<select name="employee_id" class="form-control" required>
@foreach($employees as $e)
<option value="{{ $e->id }}" {{ $allowance->employee_id == $e->id ? 'selected' : '' }}>{{ $e->full_name }}</option>
@endforeach
</select>
</div>

<div class="form-group">
<label>Loại phụ cấp</label>
<input type="text" name="type" class="form-control" value="{{ $allowance->type }}" required>
</div>

<div class="form-group">
<label>Số tiền</label>
<input type="number" name="amount" class="form-control" step="0.01" value="{{ $allowance->amount }}" required>
</div>

<div class="form-group">
<label>Tháng</label>
<input type="month" name="month" class="form-control" value="{{ \Carbon\Carbon::parse($allowance->month)->format('Y-m') }}" required>
</div>

<button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
</form>
