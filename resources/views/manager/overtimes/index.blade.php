<h2>Mảng OT Phòng của bạn</h2>
@foreach($overtimes as $ot)
<div style="border:1px solid #000; padding:10px; margin-bottom:10px;">
    <h4>Ngày: {{$ot->date}} | Lý do: {{$ot->reason}}</h4>
    <table border="1">
        <tr>
            <th>Nhân viên</th>
            <th>Trạng thái</th>
            <th>Lý do từ chối</th>
            <th>Hành động</th>
        </tr>
        @foreach($ot->employees as $emp)
        <tr id="ot-emp-{{$emp->id}}">
            <td>{{ $emp->employee?->full_name ?? 'Không xác định' }}</td>
            <td>{{ $emp->status }}</td>
            <td>{{ $emp->decline_reason ?? '' }}</td>
            <td>
                @if($emp->status=='employee_declined')
                    <button class="btn-accept" data-id="{{$emp->id}}">Chấp nhận</button>
                    <button class="btn-reject" data-id="{{$emp->id}}">Từ chối lý do</button>
                @elseif($emp->status=='manager_declined')
                    <span>Không tăng ca</span>
                @elseif($emp->status=='pending')
                    <span>Chờ xác nhận</span>
                @elseif($emp->status=='approved')
                    <span>Đã duyệt</span>
                @elseif($emp->status=='declined')
                    <span>Admin từ chối</span>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endforeach

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('.btn-accept').click(function(){
    let id=$(this).data('id');
    $.post('/manager/overtimes/accept-decline/'+id,{
        _token:'{{csrf_token()}}'
    }, function(res){
        if(res.success){
            $('#ot-emp-'+id).fadeOut(); // nhân viên được chấp nhận sẽ biến mất khỏi mảng
        }
    });
});
$('.btn-reject').click(function(){
    let id=$(this).data('id');
    $.post('/manager/overtimes/reject-decline/'+id,{
        _token:'{{csrf_token()}}'
    }, function(res){
        if(res.success){
            $('#ot-emp-'+id).fadeOut(); // ẩn row khỏi danh sách từ chối, giữ trong OT mảng
        }
    });
});
</script>
