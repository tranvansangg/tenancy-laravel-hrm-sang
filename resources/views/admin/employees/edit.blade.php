@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa nhân viên')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <h1 class="page-header">Nhân Viên <small>Chỉnh sửa</small></h1>
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


        <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Thông tin cơ bản -->
        <fieldset class="border p-3 mb-3">
                <legend class="w-auto px-2 fw-bold fs-5">Thông tin cơ bản</legend>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label>Mã nhân viên</label>
                        <input type="text" name="employee_code" class="form-control" value="{{ old('employee_code', $employee->employee_code) }}" required>
                        @error('employee_code') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                     <div class="col-md-4">
                        <label>Họ và tên</label>
                        <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $employee->full_name) }}" required>
                        @error('full_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                          <div class="col-md-4">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email) }}">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Biệt danh</label>
                        <input type="text" name="nickname" class="form-control" value="{{ $employee->nickname }}">
                    </div>
                    <div class="col-md-4">
                        <label>Giới tính</label>
                        <select name="gender" class="form-control">
                            <option value="">Chọn giới tính</option>
                            <option value="male" {{ $employee->gender=='male'?'selected':'' }}>Nam</option>
                            <option value="female" {{ $employee->gender=='female'?'selected':'' }}>Nữ</option>
                            <option value="other" {{ $employee->gender=='other'?'selected':'' }}>Khác</option>
                        </select>
                    </div>
               
                    <div class="col-md-4">
                        <label>Ngày sinh</label>
                        <input type="date" name="birth_date" class="form-control" value="{{ $employee->birth_date }}">
                    </div>
                    <div class="col-md-4">
                        <label>Ảnh 3x4</label>
                        <input type="file" name="avatar" class="form-control">
                        @if($employee->avatar)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$employee->avatar) }}" alt="Avatar" class="img-thumbnail" width="120">
                            </div>
                        @endif
                    </div>
                         <div class="col-md-4">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $employee->phone) }}">
                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </fieldset>

            <!-- Thông tin liên quan -->
            <fieldset class="border p-3 mb-3">
                <legend class="w-auto px-2 fw-bold fs-5">Thông tin khác</legend>
                <div class="row g-3">
                       <div class="col-md-4">
                        <label>CCCD</label>
                        <input type="text" name="cccd" class="form-control" value="{{ old('cccd', $employee->cccd) }}">
                        @error('cccd') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                   <div class="col-md-4">
                        <label>Ngày cấp CCCD</label>
                        <input type="date" name="cccd_issue_date" class="form-control" value="{{ old('cccd_issue_date', $employee->cccd_issue_date) }}">
                        @error('cccd_issue_date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Nơi cấp</label>
                        <input type="text" name="cccd_issue_place" class="form-control" value="{{ $employee->cccd_issue_place }}">
                    </div>
                    <div class="col-md-4">
                        <label>Quốc tịch</label>
                        <input type="text" name="nationality" class="form-control" value="{{ $employee->nationality }}">
                    </div>
                    <div class="col-md-4">
                        <label>Tôn giáo</label>
                        <input type="text" name="religion" class="form-control" value="{{ $employee->religion }}">
                    </div>
                    <div class="col-md-4">
                        <label>Dân tộc</label>
                        <input type="text" name="ethnicity" class="form-control" value="{{ $employee->ethnicity }}">
                    </div>
                    <div class="col-md-4">
                        <label>Nguyên quán</label>
                        <input type="text" name="birth_place" class="form-control" value="{{ $employee->birth_place }}">
                    </div>
                    <div class="col-md-4">
                        <label>Hộ khẩu</label>
                        <input type="text" name="address_permanent" class="form-control" value="{{ $employee->address_permanent }}">
                    </div>
                    <div class="col-md-4">
                        <label>Tạm trú</label>
                        <input type="text" name="temporary_address" class="form-control" value="{{ $employee->temporary_address }}">
                    </div>
                    <div class="col-md-4">
                        <label>Trạng thái</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ $employee->status ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ !$employee->status ? 'selected' : '' }}>Ngừng</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <!-- Quan hệ & chuyên môn -->
            <fieldset class="border p-3 mb-3">
                <legend class="w-auto px-2 fw-bold fs-5">Quan hệ & Chuyên môn</legend>
                <div class="row g-3">
                    <div class="col-md-4">
    <label>Ngày vào công ty</label>
    <input type="date" name="start_work_date" class="form-control" value="{{ old('start_work_date', $employee->start_work_date) }}">
    @error('start_work_date') <span class="text-danger">{{ $message }}</span> @enderror
</div>

                    <div class="col-md-4">
                        <label>Loại nhân viên</label>
                        <select name="employee_type_id" class="form-control">
                            <option value="">Chọn loại</option>
                            @foreach($employee_types as $type)
                                <option value="{{ $type->id }}" {{ $employee->employee_type_id==$type->id?'selected':'' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Bằng cấp</label>
                        <select name="degree_id" class="form-control">
                            <option value="">Chọn bằng cấp</option>
                            @foreach($degrees as $deg)
                                <option value="{{ $deg->id }}" {{ $employee->degree_id==$deg->id?'selected':'' }}>
                                    {{ $deg->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Trình độ</label>
                        <select name="education_level_id" class="form-control">
                            <option value="">Chọn trình độ</option>
                            @foreach($education_levels as $edu)
                                <option value="{{ $edu->id }}" {{ $employee->education_level_id==$edu->id?'selected':'' }}>
                                    {{ $edu->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Chuyên môn</label>
                        <select name="specialty_id" class="form-control">
                            <option value="">Chọn chuyên môn</option>
                            @foreach($specialties as $spec)
                                <option value="{{ $spec->id }}" {{ $employee->specialty_id==$spec->id?'selected':'' }}>
                                    {{ $spec->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Phòng ban</label>
                        <select name="department_id" class="form-control">
                            <option value="">Chọn phòng ban</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ $employee->department_id==$dept->id?'selected':'' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Chức vụ</label>
                        <select name="position_id" class="form-control">
                            <option value="">Chọn chức vụ</option>
                            @foreach($positions as $pos)
                                <option value="{{ $pos->id }}" {{ $employee->position_id==$pos->id?'selected':'' }}>
                                    {{ $pos->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </fieldset>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">Hủy</a>
            </div>

        </form>
    </div>
</div>
@endsection
