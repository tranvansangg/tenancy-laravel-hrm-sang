
<h1>Sửa khen thưởng</h1>
<form action="{{ route('admin.bonuses.update', $bonus->id) }}" method="POST">
@csrf
@method('PUT')

<div class="form-group">
<label>Nhân viên</label>
<select name="employee_id" class="form-control" required>
@foreach($employees as $e)
<option value="{{ $e->id }}" {{ $bonus->employee_id == $e->id ? 'selected' : '' }}>{{ $e->full_name }}--{{$e->employee_code}}</option>
@endforeach
</select>
</div>

<div class="form-group">
<label>Loại khen thưởng</label>
<input type="text" name="type" class="form-control" value="{{ $bonus->type }}" required>
</div>

<div class="form-group">
<label>Số tiền</label>
<input type="number" name="amount" class="form-control" step="0.01" value="{{ $bonus->amount }}" required>
</div>

<div class="form-group">
<label>Tháng</label>
<input type="month" name="month" class="form-control" value="{{ \Carbon\Carbon::parse($bonus->month)->format('Y-m') }}" required>
</div>

<div class="form-group">
<label>Ghi chú</label>
<textarea name="notes" class="form-control">{{ $bonus->notes }}</textarea>
</div>

<button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
</form>
