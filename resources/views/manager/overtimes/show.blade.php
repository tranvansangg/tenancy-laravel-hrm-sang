
{{-- //ẩn --}}
@extends('manager.layouts.app')
@section('content')
<div class="content-container" style="max-width:700px; margin:auto; padding:20px;">
    <h2 style="color:#1E3A8A; margin-bottom:20px;">Chi tiết Lệnh OT</h2>

    <div style="background:#f9f9f9; padding:20px; border-radius:8px; border:1px solid #ccc;">
        <p><b>Lý do:</b> {{ $overtime->reason }}</p>
        <p><b>Ngày:</b> {{ $overtime->date }}</p>
        <p><b>Giờ:</b> {{ $overtime->start_time }} - {{ $overtime->end_time }}</p>
        <p><b>Trạng thái:</b> 
            @if($overtime->status=='pending')
                <span style="background:#facc15; color:#78350f; padding:2px 6px; border-radius:4px;">Chờ duyệt</span>
            @elseif($overtime->status=='approved')
                <span style="background:#bbf7d0; color:#166534; padding:2px 6px; border-radius:4px;">Đã duyệt</span>
            @elseif($overtime->status=='declined')
                <span style="background:#fecaca; color:#991b1b; padding:2px 6px; border-radius:4px;">Từ chối</span>
            @endif
        </p>

        <h4 style="margin-top:15px;">Nhân viên tham gia:</h4>
        <ul style="padding-left:15px;">
            @foreach($overtime->employees as $emp)
                <li>
                   {{ $emp->employee_code }} - {{ $emp->full_name }} - {{ $emp->pivot->status }}
                    @if($emp->pivot->status=='declined')
                        (Lý do: {{ $emp->pivot->decline_reason }})
                    @endif
                </li>
            @endforeach
        </ul>

        <div style="margin-top:20px;">
            <a href="{{ route('manager.overtimes.index') }}" style="display:inline-block; padding:8px 12px; background:#1E3A8A; color:white; border-radius:5px; text-decoration:none;">Quay lại danh sách</a>
        </div>
    </div>
</div>
@endsection
