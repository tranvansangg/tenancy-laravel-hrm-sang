@extends('admin.layouts.app')

@section('title', 'Danh sách nhân viên')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <h1 class="page-header">Nhân Viên <small>Danh Sách</small></h1>
        @if(session('successs'))
            <div class="alert alert-success">
                {{ session('successs') }}
            </div>
        @endif

        <a href="{{ route('admin.employees.create') }}" class="btn btn-success mb-3">
            <i class="fa fa-plus"></i> Thêm nhân viên
        </a>

        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr align="center">
                    <th>ID</th>
                    <th>Mã NV</th>
                    <th>Ảnh NV</th>
                    <th>Tên NV</th>
                    <th>Biệt danh</th>
                    <th>Giới tính</th>
                    <th>Ngày sinh</th>
                    <th>CCCD</th>
                    <th>Loại NV</th>
                    <th>Bằng cấp</th>
                    <th>Trình độ</th>
                    <th>Chuyên môn</th>
                    <th>Phòng ban</th>
                    <th>Chức vụ</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $emp)
                <tr align="center">
                    <td>{{ $emp->id }}</td>
                    <td>{{ $emp->employee_code }}</td>
                    <td>
    @if($emp->avatar)
        <img src="{{ asset('storage/' . $emp->avatar) }}" alt="Avatar" width="50" height="50">
    @else
        ---
    @endif
</td>

                    <td>{{ $emp->full_name }}</td>
                    <td>{{ $emp->nickname ?? '---' }}</td>
                    <td>{{ ucfirst($emp->gender ?? '---') }}</td>
                    <td>{{ $emp->birth_date ? \Carbon\Carbon::parse($emp->birth_date)->format('d/m/Y') : '---' }}</td>
                    <td>{{ $emp->cccd ?? '---' }}</td>
                    <td>{{ $emp->employeeType->name ?? '---' }}</td>
                    <td>{{ $emp->degree->name ?? '---' }}</td>
                    <td>{{ $emp->educationLevel->name ?? '---' }}</td>
                    <td>{{ $emp->specialty->name ?? '---' }}</td>
                    <td>{{ $emp->department->name ?? '---' }}</td>
                    <td>{{ $emp->position->name ?? '---' }}</td>
                    <td>{{ $emp->status ? 'Hoạt động' : 'Ngừng' }}</td>
                    <td>
                        <a href="{{ route('admin.employees.edit', $emp->id) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil fa-fw"></i> Sửa
                        </a>
                        <form action="{{ route('admin.employees.destroy', $emp->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o fa-fw"></i> Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $employees->links() }}
    </div>
</div>
@endsection
