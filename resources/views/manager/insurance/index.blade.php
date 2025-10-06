<h2>Danh sách bảo hiểm nhân viên trong phòng ban của Trưởng phòng: {{ $manager->full_name }}</h2>

@foreach($employees as $emp)
    <h3>{{ $emp->full_name }} (Mã NV: {{ $emp->employee_code }})</h3>
    <table border="1" cellpadding="8" style="margin-bottom:20px; width:100%;">
        <tr>
            <th>Họ tên</th>
            <th>Số BHXH</th>
            <th>Số BHYT</th>
            <th>Số BHTN</th>
            <th>Ngày tham gia</th>
            <th>Trạng thái</th>
            <th>Ghi chú</th>
            <th>Hành động</th>
        </tr>
        @forelse($emp->insuranceRecords as $r)
        <tr>
            <td>{{ $emp->full_name }}</td>
            <td>{{ $r->social_insurance_number }}</td>
            <td>{{ $r->health_insurance_number }}</td>
            <td>{{ $r->unemployment_insurance_number }}</td>
            <td>{{ $r->participation_date }}</td>
            <td>{{ $r->status }}</td>
            <td>{{ $r->notes }}</td>
            <td>
                <a href="{{ route('manager.insurance.show', ['employee_id' => $emp->id]) }}">
                    Xem chi tiết
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8">Chưa có dữ liệu bảo hiểm</td>
        </tr>
        @endforelse
    </table>
@endforeach
