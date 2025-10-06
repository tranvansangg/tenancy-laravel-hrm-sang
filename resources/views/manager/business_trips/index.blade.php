@extends('manager.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Danh sách công tác của phòng</h4>
        </div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Mã công tác</th>
                            <th>Nhân viên</th>
                            <th>Mã nhân viên</th>
                            <th>Địa điểm</th>
                            <th>Thời gian</th>
                            <th>Mục đích</th>
                            <th>Chi phí dự kiến</th>
                            <th>Trạng thái</th>
                            <th>Phản hồi từ Admin</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trips as $trip)
                            <tr>
                                <td>{{ $trip->trip_code }}</td>
                                <td>{{ $trip->employee->full_name }}</td>
                                <td>{{ $trip->employee->employee_code }}</td>
                                <td>{{ $trip->location ?? $trip->destination }}</td>
                                <td>{{ \Carbon\Carbon::parse($trip->start_date)->format('d/m/Y') }} → {{ \Carbon\Carbon::parse($trip->end_date)->format('d/m/Y') }}</td>
                                <td>{{ $trip->purpose }}</td>
                                <td>{{ number_format($trip->estimated_cost, 0, ',', '.') }} đ</td>
                                <td>
                                    @if($trip->status == 'pending')
                                        <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                    @elseif($trip->status == 'approved')
                                        <span class="badge bg-success">Đã duyệt</span>
                                    @elseif($trip->status == 'rejected')
                                        <span class="badge bg-danger">Từ chối</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($trip->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($trip->admin_feedback)
                                        {{ $trip->admin_feedback }}
                                    @else
                                        <em>Chưa có</em>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('manager.business_trips.show', $trip->id) }}" class="btn btn-info btn-sm">Xem</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Chưa có công tác nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                {{ $trips->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
