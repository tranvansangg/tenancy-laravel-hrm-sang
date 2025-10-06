@php
    use Illuminate\Support\Facades\Auth;

    $currentEmployeeId = Auth::user()->employee->id ?? null;
    $groups = $groups ?? collect();
    // xác định các group mà current user là leader
    $leaderGroups = $groups->filter(function($g) use ($currentEmployeeId) {
        return isset($g->leader_id) && $g->leader_id == $currentEmployeeId;
    })->pluck('id')->all();
@endphp

<h2>Nhóm của tôi</h2>

@forelse($groups as $group)
<div style="border:1px solid #ccc; padding:15px; margin-bottom:15px;">
    <h3>{{ $group->name }} ({{ ucfirst($group->type ?? '') }})</h3>
    <p><strong>Mục đích nhóm:</strong> {{ $group->description ?? 'Chưa có mô tả' }}</p>

    {{-- Nếu là leader --}}
    @if(in_array($group->id, $leaderGroups))
        <a href="{{ route('employee.groups.edit_employees', $group->id) }}" class="btn btn-primary">
            Quản lý thành viên
        </a>
    @endif

    <h4>Thành viên:</h4>
    <ul>
        @forelse($group->employees ?? [] as $emp)
            <li>
                {{ $emp->full_name ?? $emp->name }} 
                (Mã NV: {{ $emp->employee_code ?? 'Chưa có' }}) 
                - Phòng: {{ $emp->department->name ?? 'Chưa có phòng' }}

                {{-- Leader --}}
                @if(isset($group->leader_id) && $emp->id == $group->leader_id)
                    <strong>(Leader)</strong>
                @endif

                {{-- Trạng thái rời nhóm --}}
                @php
                    $statusExit = $emp->pivot->status_exit ?? null;
                    $reasonExit = $emp->pivot->reason_exit ?? null;
                    $reasonResponse = $emp->pivot->reason_response ?? $emp->pivot->reason_response ?? null;
                @endphp

                @if($statusExit === 'pending')
                    - <em>Yêu cầu rời nhóm đang chờ duyệt (Lý do: {{ $reasonExit ?? '-' }})</em>

                    @if(in_array($group->id, $leaderGroups))
                        <form action="{{ route('employee.groups.handle_exit', [$group->id, $emp->id]) }}" 
                              method="POST" 
                              style="display:inline-block; margin-left:10px;">
                            @csrf
                            <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Duyệt</button>
                            <input type="text" name="reason_response" placeholder="Lý do từ chối" style="margin-left:5px;">
                            <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Từ chối</button>
                        </form>
                    @endif
                @elseif($statusExit === 'rejected')
                    - <span style="color:red; margin-left:10px;">Yêu cầu rời nhóm đã bị từ chối. Lý do: {{ $reasonResponse ?? '-' }}</span>
                @elseif($statusExit === 'approved')
                    - <em>Yêu cầu rời nhóm đã được duyệt.</em>
                @endif

                {{-- Nút xin rời nhóm (chỉ cho chính nhân viên, không phải leader) --}}
                @if($emp->id == $currentEmployeeId && !in_array($group->id, $leaderGroups))
                    @if($statusExit !== 'pending')
                        <form action="{{ route('employee.groups.request_exit', $group->id) }}" method="POST" style="display:inline">
                            @csrf
                            <input type="text" name="reason" placeholder="Lý do rời nhóm" required>
                            <button type="submit" class="btn btn-warning btn-sm">Xin rời nhóm</button>
                        </form>
                    @endif
                @endif
            </li>
        @empty
            <li>Chưa có thành viên</li>
        @endforelse
    </ul>
</div>
@empty
    <p>Bạn hiện không tham gia nhóm nào.</p>
@endforelse