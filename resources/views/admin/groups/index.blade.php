    <h2>Danh sách nhóm</h2>
    <table border="1">
        <tr>
            <th>Tên nhóm</th>
            <th>lý do thành lập</th>
            <th>Loại nhóm</th>
            <th>Leader</th>
            <th>Trạng thái</th>
            <th>Số nhân viên</th>

        </tr>
    @foreach($groups as $g)
        <tr>
            <td>{{ $g->name }}</td>
            <td>{{ $g->description ?? '-' }}</td>
            <td>{{ $g->type }}</td>
            <td>
                @if($g->leader)
                    {{ $g->leader->employee_code ?? '-' }} --
                    {{ $g->leader->full_name ?? '-' }} --
                    {{ $g->leader->department->name ?? '-' }}
                @else
                    Chưa có leader
                @endif
            </td>
            <td>{{ $g->status ?? '-' }}</td>
            <td>
                <a href="{{ route('admin.groups.edit_leader',$g->id) }}">Thay đổi leader</a>
                <a href="{{ route('admin.groups.toggle',$g->id) }}">
                    {{ $g->status=='active' ? 'Tạm ngưng' : 'Kích hoạt' }}
                </a>
            </td>
        </tr>
    @endforeach
    </table>
