@extends('admin.layouts.app')

@section('title', 'Danh Sách Bằng Cấp')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Bằng Cấp
                    <small>Danh Sách</small>
                </h1>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <a href="{{ route('admin.degrees.create') }}" class="btn btn-success mb-3">
                <i class="fa fa-plus"></i> Thêm Bằng Cấp
            </a>

            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Mã Bằng Cấp</th>
                        <th>Tên Bằng Cấp</th>
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
                    @foreach($degrees as $degree)
                        <tr align="center">
                            <td>{{ $degree->id }}</td>
                            <td>{{ $degree->code }}</td>
                            <td>{{ $degree->name }}</td>
                            <td>{{ $degree->description ?? '---' }}</td>
                            <td>{{ $degree->created_at->format('d/m/Y') }}</td>
                            <td>{{ $degree->creator ? $degree->creator->first_name . ' ' . $degree->creator->last_name : 'N/A' }}</td>
                            <td>
                                @if($degree->updated_at && $degree->updated_at != $degree->created_at)
                                    {{ $degree->updated_at->format('d/m/Y') }}
                                @else
                                    Chưa cập nhật
                                @endif
                            </td>
                            <td>{{ $degree->updater ? $degree->updater->first_name . ' ' . $degree->updater->last_name : '---' }}</td>
                            <td>
                                <a href="{{ route('admin.degrees.edit', $degree->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-pencil fa-fw"></i> Sửa
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('admin.degrees.destroy', $degree->id) }}" method="POST" 
                                      onsubmit="return confirm('Bạn có chắc muốn xóa bằng cấp này không?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash-o fa-fw"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $degrees->links() }}
        </div>
    </div>
</div>
@endsection
