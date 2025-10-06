
<h1>Thêm khấu trừ</h1>
<form action="{{ route('admin.deductions.store') }}" method="POST">
@csrf
<div class="form-group">
<label>Nhân viên</label>
<select name="employee_id" class="form-control" required>
@foreach($employees as $e)
<option value="{{ $e->id }}">{{ $e->full_name }}-{{$e->employee_code}}</option>
@endforeach
</select>
</div>

<div class="form-group">
<label>Loại khấu trừ</label>
<input type="text" name="type" class="form-control" required>
</div>

<div class="form-group">
<label>Số tiền</label>
<input type="number" name="amount" class="form-control" step="0.01" required>
</div>

<div class="form-group">
<label>Tháng</label>
<input type="month" name="month" class="form-control" required>
</div>

<button type="submit" class="btn btn-primary mt-2">Lưu</button>
</form>

