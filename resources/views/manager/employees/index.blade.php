
<div class="container">
    <h3>Danh sách nhân viên trong phòng bạn</h3>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Mã NV</th>
                <th>Họ tên</th>
                <th>Chức vụ</th>
                <th>Email</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $emp)
                <tr>
                    <td>{{ $emp->employee_code }}</td>
                    <td>{{ $emp->full_name }}</td>
                    <td>{{ $emp->position->name ?? '-' }}</td>
                    <td>{{ $emp->email }}</td>
                    <td>{{ $emp->status ? 'Đang làm' : 'Nghỉ việc' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

