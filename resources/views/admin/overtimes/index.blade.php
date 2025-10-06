<h2>Duyệt OT</h2>
@foreach($overtimes as $ot)
<div style="border:1px solid #000; padding:10px; margin-bottom:10px;">
    <h4>Ngày: {{$ot->date}} | Lý do: {{$ot->reason}}</h4>
    <table border="1">
        <tr>
            <th>Nhân viên</th>
            <th>Giờ</th>
            <th>Trạng thái</th>
            <th>Tiền OT (VND)</th>
        </tr>
        @foreach($ot->employees as $emp)
        @if($emp->status != 'manager_declined')
        <tr>
<td>
    {{$emp->employee->employee_code}} -- {{$emp->employee->full_name}} -- 
    {{ $emp->employee->department->name ?? 'Chưa có phòng' }}
</td>            <td>{{ $emp->start_time ?? $ot->start_time }} - {{ $emp->end_time ?? $ot->end_time }}</td>
            <td>{{$emp->status}}</td>
            <td>{{ number_format($emp->ot_amount ?? 0) }}</td>
        </tr>
        @endif
        @endforeach
    </table>
    <p><strong>Tổng tiền OT: {{ number_format($ot->total_ot_amount) }} VND</strong></p>


    <form method="POST" action="{{ route('admin.overtimes.approve',$ot->id) }}" style="display:inline">
        @csrf
        <button>Approve</button>
    </form>
    <form method="POST" action="{{ route('admin.overtimes.decline',$ot->id) }}" style="display:inline">
        @csrf
        <button>Decline</button>
    </form>
</div>

@endforeach
    <p><strong>Tổng tiền OT tất cả mảng: {{ number_format($grand_total_ot) }} VND</strong></p>
