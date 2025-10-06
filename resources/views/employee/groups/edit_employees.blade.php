
<h2>Quản lý thành viên nhóm: {{ $group->name }}</h2>

<form action="{{ route('employee.groups.update_employees', $group->id) }}" method="POST">
    @csrf
    @method('PUT')

    @foreach($employees as $e)
        {{-- Không hiển thị leader --}}
        @if($e->id != $group->leader_id)
            <label>
                <input type="checkbox" name="employee_ids[]" value="{{ $e->id }}"
                    @if($group->employees->contains($e->id)) checked @endif>
                {{ $e->full_name ?? $e->name }} - {{ $e->department->name ?? 'Chưa có phòng ban' }}
            </label>
            <br>
        @endif
    @endforeach

    <button type="submit" class="btn btn-success">Cập nhật nhân viên</button>
</form>
