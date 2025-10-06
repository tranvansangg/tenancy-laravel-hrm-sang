@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Chỉnh sửa nhóm</h2>

    <form action="{{ route('admin.groups.update', $group->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Tên nhóm</label>
            <input type="text" name="name" value="{{ $group->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control">{{ $group->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Loại nhóm</label>
            <select name="type" class="form-control">
                <option value="project" {{ $group->type == 'project' ? 'selected' : '' }}>Dự án</option>
                <option value="department" {{ $group->type == 'department' ? 'selected' : '' }}>Phòng ban</option>
                <option value="other" {{ $group->type == 'other' ? 'selected' : '' }}>Khác</option>
            </select>
        </div>

       

        <div class="mb-3">
            <label>Trưởng nhóm</label>
            <select name="leader_id" class="form-control">
                @foreach($leaders as $leader)
                    <option value="{{ $leader->id }}" {{ $group->leader_id == $leader->id ? 'selected' : '' }}>
                        {{$leader->employee_code}} -- {{ $leader->full_name }} -- {{$leader->department->name}}
                    </option>
                @endforeach
            </select>
        </div>

        
        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('admin.groups.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
