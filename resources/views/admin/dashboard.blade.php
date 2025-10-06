@extends('admin.layouts.app')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <h1>Admin Dashboard</h1>

                {{-- Thông báo công tác mới --}}
                @if($pendingTrips->count() > 0)
                    <div class="alert alert-warning mt-3">
                        <strong>Thông báo:</strong> Có {{ $pendingTrips->count() }} công tác mới cần duyệt.
                    </div>

                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Nhân viên</th>
                                <th>Tiêu đề</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingTrips as $trip)
                                <tr>
                                    <td>{{ $trip->employee->full_name ?? 'N/A' }}</td>
                                    <td>{{ $trip->title }}</td>
                                    <td>{{ $trip->start_date }}</td>
                                    <td>{{ $trip->end_date }}</td>
                                    <td>
                                        <a href="{{ route('admin.business_trips.show', $trip->id) }}" class="btn btn-primary btn-sm">Xem chi tiết</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-success mt-3">
                        Hiện tại không có công tác nào chờ duyệt.
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
    