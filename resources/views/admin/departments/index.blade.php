@extends('admin.layouts.app') {{-- nếu Sang có layout admin --}}

@section('title', 'Danh Sách Phòng Ban')

@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Phòng Ban
                    <small>Danh Sách</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <a href="{{ route('admin.departments.create') }}" class="btn btn-success" style="margin-bottom:15px">
                <i class="fa fa-plus"></i> Thêm Phòng Ban
            </a>

     <table class="table table-striped table-bordered table-hover" id="dataTables-example">
    <thead>
        <tr align="center">
            <th>ID</th>
            <th>Mã phòng ban</th>
            <th>Tên phòng ban</th>
            <th>Mô tả</th>
            <th>Ngày tạo</th>
            <th>Người tạo</th>
            <th>Ngày cập nhật</th>
            <th>Người cập nhật</th>
            <th>Sửa</th>
            <th>Xóa</th>
            <th>Trạng thái</th> <!-- Thêm cột trạng thái -->
        </tr>
    </thead>
    <tbody>
        @foreach($departments as $dept)
            <tr align="center">
                <td>{{ $dept->id }}</td>
                <td>{{ $dept->code }}</td>
                <td>{{ $dept->name }}</td>
                <td>{{ $dept->description }}</td>
                <td>{{ $dept->created_at->format('d/m/Y') }}</td>
                <td>{{ $dept->creator ? $dept->creator->first_name . ' ' . $dept->creator->last_name : 'N/A' }}</td>
           <td>
    @if($dept->updated_at && $dept->updated_at != $dept->created_at)
        {{ $dept->updated_at->format('d/m/Y') }}
    @else
        Chưa cập nhật
    @endif
</td>
<td>
    {{ $dept->updater ? $dept->updater->first_name . ' ' . $dept->updater->last_name : 'Chưa cập nhật' }}
</td>
              <td>
    @if($dept->status == 1)
        <span class="badge badge-success">Hiển thị</span>
    @else
        <span class="badge badge-secondary">Ẩn</span>
    @endif
</td>


                <td>
                    <a href="{{ route('admin.departments.edit', $dept->id) }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-pencil fa-fw"></i> Sửa
                    </a>
                </td>
                <td>
                    <form action="{{ route('admin.departments.destroy', $dept->id) }}" method="POST" 
                          onsubmit="return confirm('Bạn có chắc muốn xóa phòng ban này không?');">
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


        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

@endsection
