<h2>Chi tiết bảo hiểm của nhân viên: {{ $employee->full_name }}</h2>

<p><strong>Mã NV:</strong> {{ $employee->employee_code }}</p>
<p><strong>Phòng ban:</strong> {{ $employee->department->name ?? '---' }}</p>

<table border="1" cellpadding="8" style="margin-top:20px;">
    <tr>
        <th>Số BHXH</th>
        <th>Số BHYT</th>
        <th>Số BHTN</th>
        <th>Ngày tham gia</th>
        <th>Trạng thái</th>
        <th>Ghi chú</th>
    </tr>
    @forelse($employee->insuranceRecords as $r)
    <tr>
        <td>{{ $r->social_insurance_number }}</td>
        <td>{{ $r->health_insurance_number }}</td>
        <td>{{ $r->unemployment_insurance_number }}</td>
        <td>{{ $r->participation_date }}</td>
        <td>{{ $r->status }}</td>
        <td>{{ $r->notes }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="6">Chưa có dữ liệu bảo hiểm</td>
    </tr>
    @endforelse
</table>

<a href="{{ route('manager.insurance.index') }}">← Quay lại danh sách</a>
