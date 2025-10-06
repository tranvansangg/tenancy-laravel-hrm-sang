@extends('admin.layouts.app')

@section('title', 'Danh Sách Trình Độ')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <h1 class="page-header">Trình Độ
            <small>Danh Sách</small>
        </h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.education_levels.create') }}" class="btn btn-success" style="margin-bottom:15px">
            <i class="fa fa-plus"></i> Thêm Trình Độ
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
                @foreach($educationLevels as $level)
                    <tr align="center">
                        <td>{{ $level->id }}</td>
                        <td>{{ $level->code }}</td>
                        <td>{{ $level->name }}</td>
                        <td>{{ $level->description ?? '---' }}</td>
                        <td>{{ $level->created_at->format('d/m/Y') }}</td>
                        <td>{{ $level->creator ? $level->creator->first_name . ' ' . $level->creator->last_name : 'N/A' }}</td>
                        <td>
                            @if($level->updated_at && $level->updated_at != $level->created_at)
                                {{ $level->updated_at->format('d/m/Y') }}
                            @else
                                Chưa cập nhật
                            @endif
                        </td>
                        <td>{{ $level->updater ? $level->updater->first_name . ' ' . $level->updater->last_name : 'Chưa cập nhật' }}</td>
                        <td>
                            <a href="{{ route('admin.education_levels.edit', $level->id) }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-pencil fa-fw"></i> Sửa
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('admin.education_levels.destroy', $level->id) }}" method="POST" 
                                  onsubmit="return confirm('Bạn có chắc muốn xóa Trình Độ này không?');">
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

        {{ $educationLevels->links() }}
    </div>
</div>
@endsection
