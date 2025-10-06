@extends('admin.layouts.app')

@section('title', 'Thêm mới nhân viên')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <h1 class="page-header">Nhân Viên <small>Thêm mới</small></h1>

        <!-- Hiển thị lỗi chung nếu có -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Thông tin cơ bản -->
            <fieldset class="border p-3 mb-3">
                <legend class="w-auto px-2 fw-bold fs-5">Thông tin cơ bản</legend>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label>Mã nhân viên</label>
                        <input type="text" name="employee_code" class="form-control" value="{{ old('employee_code') }}" required>
                        @error('employee_code') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Họ và tên</label>
                        <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required>
                        @error('full_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Biệt danh</label>
                        <input type="text" name="nickname" class="form-control" value="{{ old('nickname') }}">
                    </div>
                    <div class="col-md-4">
                        <label>Giới tính</label>
                        <select name="gender" class="form-control">
                            <option value="">Chọn giới tính</option>
                            <option value="male" {{ old('gender')=='male' ? 'selected' : '' }}>Nam</option>
                            <option value="female" {{ old('gender')=='female' ? 'selected' : '' }}>Nữ</option>
                            <option value="other" {{ old('gender')=='other' ? 'selected' : '' }}>Khác</option>
                        </select>
                        @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Ngày sinh</label>
                        <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}">
                        @error('birth_date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Ảnh 3x4</label>
                        <input type="file" name="avatar" class="form-control">
                        @error('avatar') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </fieldset>

            <!-- Thông tin liên quan -->
            <fieldset class="border p-3 mb-3">
                <legend class="w-auto px-2 fw-bold fs-5">Thông tin liên quan</legend>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label>CCCD</label>
                        <input type="text" name="cccd" class="form-control" value="{{ old('cccd') }}">
                        @error('cccd') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Ngày cấp CCCD</label>
                        <input type="date" name="cccd_issue_date" class="form-control" value="{{ old('cccd_issue_date') }}">
                        @error('cccd_issue_date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Nơi cấp</label>
                        <input type="text" name="cccd_issue_place" class="form-control" value="{{ old('cccd_issue_place') }}">
                        @error('cccd_issue_place') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Quốc tịch</label>
                        <input type="text" name="nationality" class="form-control" value="{{ old('nationality') }}">
                        @error('nationality') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Tôn giáo</label>
                        <input type="text" name="religion" class="form-control" value="{{ old('religion') }}">
                        @error('religion') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Dân tộc</label>
                        <input type="text" name="ethnicity" class="form-control" value="{{ old('ethnicity') }}">
                        @error('ethnicity') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Nguyên quán</label>
                        <input type="text" name="address_permanent" class="form-control" value="{{ old('address_permanent') }}">
                        @error('address_permanent') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Hộ khẩu</label>
                        <input type="text" name="address_resident" class="form-control" value="{{ old('address_resident') }}">
                        @error('address_resident') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Tạm trú</label>
                        <input type="text" name="temporary_address" class="form-control" value="{{ old('temporary_address') }}">
                        @error('temporary_address') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Tình trạng hôn nhân</label>
                        <select name="marital_status" class="form-control">
                            <option value="single" {{ old('marital_status')=='single' ? 'selected':'' }}>Độc thân</option>
                            <option value="married" {{ old('marital_status')=='married' ? 'selected':'' }}>Đã kết hôn</option>
                        </select>
                        @error('marital_status') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Trạng thái</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status')=='1' ? 'selected':'' }}>Hoạt động</option>
                            <option value="0" {{ old('status')=='0' ? 'selected':'' }}>Ngừng</option>
                        </select>
                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </fieldset>

            <!-- Quan hệ & chuyên môn -->
            <fieldset class="border p-3 mb-3">
                <legend class="w-auto px-2 fw-bold fs-5">Quan hệ & chuyên môn</legend>

                <div class="row g-3">
                    <div class="col-md-4">
    <label>Ngày vào công ty</label>
    <input type="date" name="start_work_date" class="form-control" value="{{ old('start_work_date') }}">
    @error('start_work_date') <span class="text-danger">{{ $message }}</span> @enderror
</div>

                    <div class="col-md-4">
                        <label>Loại nhân viên</label>
                        <select name="employee_type_id" class="form-control">
                            <option value="">Chọn loại nhân viên</option>
                            @foreach($employee_types as $type)
                                <option value="{{ $type->id }}" {{ old('employee_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('employee_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Bằng cấp</label>
                        <select name="degree_id" class="form-control">
                            <option value="">Chọn bằng cấp</option>
                            @foreach($degrees as $deg)
                                <option value="{{ $deg->id }}" {{ old('degree_id') == $deg->id ? 'selected' : '' }}>
                                    {{ $deg->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('degree_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Trình độ</label>
                        <select name="education_level_id" class="form-control">
                            <option value="">Chọn trình độ</option>
                            @foreach($education_levels as $edu)
                                <option value="{{ $edu->id }}" {{ old('education_level_id') == $edu->id ? 'selected' : '' }}>
                                    {{ $edu->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('education_level_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Chuyên môn</label>
                        <select name="specialty_id" class="form-control">
                            <option value="">Chọn chuyên môn</option>
                            @foreach($specialties as $spec)
                                <option value="{{ $spec->id }}" {{ old('specialty_id') == $spec->id ? 'selected' : '' }}>
                                    {{ $spec->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('specialty_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Phòng ban</label>
                        <select name="department_id" class="form-control">
                            <option value="">Chọn phòng ban</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Chức vụ</label>
                        <select name="position_id" class="form-control">
                            <option value="">Chọn chức vụ</option>
                            @foreach($positions as $pos)
                                <option value="{{ $pos->id }}" {{ old('position_id') == $pos->id ? 'selected' : '' }}>
                                    {{ $pos->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('position_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </fieldset>

            <div class="mt-3">
                <button type="submit" class="btn btn-success">Thêm nhân viên</button>
                <button type="reset" class="btn btn-secondary">Làm lại</button>
            </div>
        </form>
    </div>
</div>
@endsection
