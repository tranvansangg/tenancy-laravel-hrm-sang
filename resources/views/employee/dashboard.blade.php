@extends('employee.layouts.app')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <h1>Dashboard nhân viên</h1>

        {{-- Thông báo công tác --}}
        <div class="mt-3">
            <h4>Thông báo công tác</h4>

            @if($notifications->count())
                @foreach($notifications as $trip)
                    <div class="alert alert-success">
                        <strong>{{ $trip->employee->full_name }}</strong>
                        được phê duyệt công tác
                        ({{ $trip->trip_code }}) tại <b>{{ $trip->location }}</b>
                        từ {{ $trip->start_date }} đến {{ $trip->end_date }}.
                        <br>
                        <em>Phản hồi admin:</em> {{ $trip->admin_feedback ?? 'Không có' }}
                        <br>
                        <a href="{{ route('employee.business_trips.show', $trip->id) }}">Xem chi tiết</a>
                    </div>
                @endforeach
            @else
                <p class="text-muted">Không có thông báo công tác mới.</p>
            @endif
        </div>
    </div>
</div>
@endsection
