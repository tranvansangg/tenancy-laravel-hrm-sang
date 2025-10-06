@extends('employee.layouts.app')
@section('content')
<h2>Danh sách OT của tôi</h2>
<table>
    <thead>
        <tr>
            <th>Ngày</th>
            <th>Giờ</th>
            <th>Lý do OT</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($overtimes as $ot)
        <tr id="ot-{{ $ot->id }}">
            <td>{{ $ot->overtime->date }}</td>
            <td>{{ $ot->overtime->start_time }} - {{ $ot->overtime->end_time }}</td>
            <td>{{ $ot->overtime->reason }}</td>
            <td id="status-{{ $ot->id }}">{{ $ot->status }}</td>
            <td>
                @if($ot->status == 'pending' || $ot->status == 'approved') 
                    <button onclick="declineOT({{ $ot->id }})">Từ chối</button>
                @elseif($ot->status == 'employee_declined')
                    <span>Chờ Trưởng phòng duyệt lý do</span>
                @else
                    <span>Không tăng ca</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
function declineOT(id){
    let reason = prompt("Nhập lý do từ chối:");
    if(reason){
        fetch(`/employee/overtimes/${id}/decline`,{
            method:'POST',
            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body: JSON.stringify({reason:reason})
        })
        .then(res=>res.json())
        .then(data=>{
            if(data.success){
                document.getElementById('status-'+id).innerText='employee_declined';
            }
        });
    }
}
</script>
@endsection
