{{-- resources/views/manager/groups/edit_employees.blade.php --}}
@extends('layouts.manager')

@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Quản lý thành viên nhóm: {{ $group->name }}</h2>
    <p><strong>Mục đích nhóm:</strong> {{ $group->description ?? 'Chưa có mô tả' }}</p>

    <form action="{{ route('manager.groups.update_employees', $group->id) }}" method="POST">
        @csrf

        <div class="mb-4">
            <h4 class="text-lg font-semibold mb-2">Danh sách nhân viên</h4>

            @foreach($employees as $e)
                @php
                    // Lấy pivot nếu employee có trong nhóm
                    $pivot = $group->employees->firstWhere('id', $e->id)?->pivot;
                @endphp

                <label class="block mb-2">
                    <input type="checkbox" name="employee_ids[]" value="{{ $e->id }}"
                        @if($group->employees->contains($e->id)) checked @endif
                        @if($e->id == $group->leader_id) disabled @endif
                    >
                    {{ $e->employee_code }} - {{ $e->full_name ?? $e->name }}
                    (Phòng: {{ $e->department->name ?? 'Chưa có phòng' }})

                    @if($e->id == $group->leader_id)
                        <strong>(Leader - luôn có trong nhóm)</strong>
                    @endif

                    @if($pivot && $pivot->status_exit)
                        @if($pivot->status_exit == 'pending')
                            <span class="text-orange-500"> - Đang xin rời nhóm</span>
                        @elseif($pivot->status_exit == 'rejected')
                            <span class="text-red-500"> - Bị từ chối: {{ $pivot->reason_exit }}</span>
                        @elseif($pivot->status_exit == 'approved')
                            <span class="text-gray-500"> - Đã rời nhóm</span>
                        @endif
                    @endif
                </label>
            @endforeach
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Cập nhật thành viên
            </button>
            <a href="{{ route('manager.groups.my_groups') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                Quay lại
            </a>
        </div>
    </form>
</div>
@endsection
