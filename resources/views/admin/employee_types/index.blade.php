@extends('admin.layouts.app')

@section('title','Danh Sách Loại Nhân Viên')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Loại Nhân Viên
                    <small>Danh Sách</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <a href="{{ route('admin.employee_types.create') }}" class="btn btn-success" style="margin-bottom:15px">
                <i class="fa fa-plus"></i> Thêm Loại Nhân Viên
            </a>

            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Mã</th>
                        <th>Tên</th>
                        <th>Mô tả</th>
                        <th>Ngày tạo</th>
                        <th>Người tạo</th>
                        <th>Ngày cập nhật</th>
                        <th>Người cập nhật</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($types as $type)
                        <tr align="center">
                            <td>{{ $type->id }}</td>
                            <td>{{ $type->code }}</td>
                            <td>{{ $type->name }}</td>
                            <td>{{ $type->description ?? '---' }}</td>
                            <td>{{ $type->created_at->format('d/m/Y') }}</td>
                            <td>{{ $type->creator ? $type->creator->first_name . ' ' . $type->creator->last_name : 'N/A' }}</td>
                            <td>
                                @if($type->updated_at && $type->updated_at != $type->created_at)
                                    {{ $type->updated_at->format('d/m/Y') }}
                                @else
                                    Chưa cập nhật
                                @endif
                            </td>
                            <td>{{ $type->updater ? $type->updater->first_name . ' ' . $type->updater->last_name : '---' }}</td>
                            <td>
                                <a href="{{ route('admin.employee_types.edit', $type->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-pencil fa-fw"></i> Sửa
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('admin.employee_types.destroy', $type->id) }}" method="POST"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa Loại Nhân Viên này không?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash-o fa-fw"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $types->links() }}

        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection
