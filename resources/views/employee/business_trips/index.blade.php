@extends('employee.layouts.app')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <h1>Công tác của tôi</h1>

        @if($businessTrips->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã</th>
                        <th>Mã nhân viên</th>
                        <th>Địa điểm</th>
                        <th>Thời gian</th>
                        <th>Phản hồi admin</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($businessTrips as $trip)
                        <tr>
                            <td>{{ $trip->trip_code }}</td>
                            <td>{{ $trip->employee->employee_code }}</td>
                            <td>{{ $trip->location }}</td>
                            <td>{{ $trip->start_date }} → {{ $trip->end_date }}</td>
                            <td>{{ $trip->admin_feedback ?? 'Không có' }}</td>
                            <td><a href="{{ route('employee.business_trips.show', $trip->id) }}" class="btn btn-info btn-sm">Xem</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $businessTrips->links() }}
        @else
            <p class="text-muted">Chưa có công tác nào được duyệt.</p>
        @endif
    </div>
</div>
@endsection
