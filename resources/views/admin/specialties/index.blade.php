@extends('admin.layouts.app')

@section('title','Danh Sách Chuyên Môn')

@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Chuyên Môn
                    <small>Danh Sách</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <a href="{{ route('admin.specialties.create') }}" class="btn btn-success" style="margin-bottom:15px">
                <i class="fa fa-plus"></i> Thêm Chuyên Môn
            </a>

            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Mã chuyên môn</th>
                        <th>Tên chuyên môn</th>
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
                    @foreach($specialties as $spec)
                        <tr align="center">
                            <td>{{ $spec->id }}</td>
                            <td>{{ $spec->code }}</td>
                            <td>{{ $spec->name }}</td>
                            <td>{{ $spec->description ?? '---' }}</td>
                            <td>{{ $spec->created_at->format('d/m/Y') }}</td>
                            <td>{{ $spec->creator ? $spec->creator->first_name . ' ' . $spec->creator->last_name : 'N/A' }}</td>
                            <td>
                                @if($spec->updated_at && $spec->updated_at != $spec->created_at)
                                    {{ $spec->updated_at->format('d/m/Y') }}
                                @else
                                    Chưa cập nhật
                                @endif
                            </td>
                            <td>
                                {{ $spec->updater ? $spec->updater->first_name . ' ' . $spec->updater->last_name : 'Chưa cập nhật' }}
                            </td>
                            <td>
                                <a href="{{ route('admin.specialties.edit', $spec->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-pencil fa-fw"></i> Sửa
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('admin.specialties.destroy', $spec->id) }}" method="POST" 
                                    onsubmit="return confirm('Bạn có chắc muốn xóa chuyên môn này không?');">
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

            {{-- Phân trang --}}
            <div class="text-center">
                {{ $specialties->links() }}
            </div>

        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

@endsection
