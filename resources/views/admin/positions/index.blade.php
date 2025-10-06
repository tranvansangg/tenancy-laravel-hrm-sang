@extends('admin.layouts.app') {{-- nếu em có layout admin --}}

@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-between align-items-center">
                    <h1 class="page-header">Chức vụ
                        <small>Danh sách</small>
                    </h1>
                    <a href="{{ route('admin.positions.create') }}" class="btn btn-success">
                        <i class="fa fa-plus"></i> Thêm chức vụ
                    </a>
                </div>
                <!-- /.col-lg-12 -->

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

              <table class="table table-striped table-bordered table-hover" id="dataTables-example">
    <thead>
        <tr align="center">
            <th>ID</th>
            <th>Mã chức vụ</th>
            <th>Tên chức vụ</th>
            <th>Lương ngày</th>
            <th>Mô tả</th>
            <th>Trạng thái</th> <!-- Thêm cột trạng thái -->
            <th>Xóa</th>
            <th>Sửa</th>
        </tr>
    </thead>
    <tbody>
        @foreach($positions as $position)
            <tr class="odd gradeX" align="center">
                <td>{{ $position->id }}</td>
                <td>{{ $position->code }}</td>
                <td>{{ $position->name }}</td>
                <td>{{ number_format($position->daily_salary, 0, ',', '.') }} đ</td>
                <td>{{ $position->description ?? '---' }}</td>
              <td>
    @if($position->status == 1)
        <span class="badge badge-success">Hiển thị</span>
    @else
        <span class="badge badge-secondary">Ẩn</span>
    @endif
</td>

                <td class="center">
                    <form action="{{ route('admin.positions.destroy', $position->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">
                            <i class="fa fa-trash-o fa-fw"></i> Xóa
                        </button>
                    </form>
                </td>
                <td class="center">
                    <a href="{{ route('admin.positions.edit', $position->id) }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-pencil fa-fw"></i> Sửa
                    </a>
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
