@extends('manager.layouts.app')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <h1>Manager Dashboard</h1>

                {{-- Thông báo công tác được admin duyệt/từ chối --}}
                @if($notifications->count())
                    <div class="mt-3">
                        <h4>Thông báo công tác</h4>
                        @foreach($notifications as $trip)
                            <div class="alert alert-{{ $trip->status == 'approved' ? 'success' : 'danger' }}">
                                <strong>{{ $trip->employee->full_name }}</strong> 
                                được {{ $trip->status == 'approved' ? 'phê duyệt' : 'từ chối' }} công tác
                                ({{ $trip->trip_code }}) tại <b>{{ $trip->location }}</b> 
                                từ {{ $trip->start_date }} đến {{ $trip->end_date }}.
                                <br>
                                <em>Phản hồi admin:</em> {{ $trip->admin_feedback ?? 'Không có' }}
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Không có thông báo công tác từ Giám Đốc.</p>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
