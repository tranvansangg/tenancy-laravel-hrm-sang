

@php
    use Illuminate\Support\Facades\DB;

    $currentEmployeeId = auth()->user()->employee->id ?? null;
    $tenantId = auth()->user()->tenant_id ?? null;
    $memberGroupIds = [];

    if ($currentEmployeeId && $tenantId) {
        $memberGroupIds = DB::table('group_employee')
            ->where('tenant_id', $tenantId)
            ->where('employee_id', $currentEmployeeId)
            ->pluck('group_id')
            ->toArray();
    }

    // Chỉ giữ những nhóm mà nhân viên hiện tại tham gia
    $groups = collect($groups)->filter(function($g) use ($memberGroupIds) {
        return in_array($g->id, $memberGroupIds);
    })->values();
@endphp

<h2>Danh sách nhóm của tôi</h2>
<table border="1">
    <tr>
        <th>Tên nhóm</th>
        <th>Lý do thành lập</th>
        <th>Loại nhóm</th>
        <th>Leader</th>
        <th>Trạng thái</th>
        <th>Thành viên</th>
    </tr>

@foreach($groups as $g)
    <tr>
        <td>{{ $g->name }}</td>
        <td>{{ $g->description ?? '-' }}</td>
        <td>{{ $g->type }}</td>
        <td>
            @php
                $leader = $g->leader ?? ($employees->firstWhere('id', $g->leader_id) ?? null);
            @endphp

            @if($leader)
                {{ $leader->employee_code ?? '-' }} --
                {{ $leader->full_name ?? '-' }} --
                {{ $leader->department->name ?? '-' }}
            @else
                Chưa có leader
            @endif
        </td>
        <td>{{ $g->status ?? '-' }}</td>
        <td>
            @php
                // Lấy danh sách member ids từ pivot cho nhóm này (chỉ tenant hiện tại)
                $memberIds = DB::table('group_employee')
                    ->where('group_id', $g->id)
                    ->when($tenantId, fn($q) => $q->where('tenant_id', $tenantId))
                    ->pluck('employee_id')
                    ->toArray();

                // Lọc collection $employees (được controller truyền) theo memberIds
                $groupMembers = $employees->whereIn('id', $memberIds);
            @endphp

            @if($groupMembers->isEmpty())
                Chưa có thành viên
            @else
                <ul>
                    @foreach($groupMembers as $emp)
                        <li>
                            {{ $emp->employee_code ?? '-' }} --
                            {{ $emp->full_name ?? '-' }} --
                            {{ $emp->department->name ?? '-' }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </td>
    </tr>
@endforeach
</table>
