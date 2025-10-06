<h2>Bảo hiểm của tôi (Trưởng phòng: {{ $manager->full_name }})</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Số BHXH</th>
        <th>Số BHYT</th>
        <th>Số BHTN</th>
        <th>Ngày tham gia</th>
        <th>Trạng thái</th>
        <th>Ghi chú</th>
    </tr>
    @foreach($records as $r)
    <tr>
        <td>{{ $r->social_insurance_number }}</td>
        <td>{{ $r->health_insurance_number }}</td>
        <td>{{ $r->unemployment_insurance_number }}</td>
        <td>{{ $r->participation_date }}</td>
        <td>{{ $r->status }}</td>
        <td>{{ $r->notes }}</td>
    </tr>
    @endforeach
</table>
