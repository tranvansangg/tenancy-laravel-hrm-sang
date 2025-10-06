
<h2>Tạo nhóm mới</h2>
@if(session('leader_assigned'))
<div class="alert alert-success">{{ session('leader_assigned') }}</div>
@endif
<form action="{{ route('admin.groups.store') }}" method="POST">
@csrf
<label>Tên nhóm</label>
<input type="text" name="name" required>

<label>Loại nhóm</label>
<select name="type" required>
<option value="project">Nhóm dự án</option>
<option value="department">Nhóm phòng ban</option>
</select>

<label>Leader nhóm</label>
<select name="leader_id" required>
@foreach($employees as $e)
<option value="{{ $e->id }}">{{ $e->full_name }} - {{ $e->employee_code }} - {{ $e->department->name }}</option>
@endforeach
</select>

<label>Mô tả nhóm (tùy chọn)</label>
<textarea name="description"></textarea>

<button type="submit">Tạo nhóm</button>
</form>
