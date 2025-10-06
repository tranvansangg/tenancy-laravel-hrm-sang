@extends('manager.layouts.app')
@section('content')
{{-- CSS để giao diện thêm phần sống động --}}
<style>
    .card {
        transition: all 0.3s ease-in-out;
        overflow: hidden; /* Đảm bảo các hiệu ứng không bị tràn ra ngoài card */
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12) !important;
    }
    .form-control:focus {
        border-color: #0d6efd; /* Màu primary của Bootstrap */
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    /* === Cải tiến phần Avatar === */
    .avatar-upload-container {
        display: flex;
        align-items: center;
        gap: 20px; /* Khoảng cách giữa ảnh và input */
    }
    .avatar-preview-wrapper {
        position: relative;
        cursor: pointer;
    }
    .avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #f8f9fa; /* Thêm viền nhẹ cho ảnh */
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    .avatar-preview:hover {
        transform: scale(1.05);
    }
    /* Ẩn input file gốc */
    #avatar {
        display: none;
    }
    /* Nút "Chọn ảnh" tùy chỉnh */
    .custom-file-upload {
        display: inline-block;
        padding: 10px 18px;
        cursor: pointer;
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: 6px;
        font-weight: 500;
        transition: background-color 0.2s;
    }
    .custom-file-upload:hover {
        background-color: #dde1e4;
    }
</style>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-11">
            {{-- PHẦN 1: CHỈNH SỬA THÔNG TIN CÁ NHÂN --}}
            <div class="card shadow-lg border-0 rounded-lg mb-5">
                <div class="card-header bg-success text-white text-center">
                    <h3 class="font-weight-light my-3"><i class="fas fa-user-edit me-2"></i>Thông Tin Cá Nhân</h3>
                </div>
                <div class="card-body p-4 p-md-5">
                    {{-- Thông báo thành công --}}
                    @if(session('success_info'))
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <div>{{ session('success_info') }}</div>
                        </div>
                    @endif
                    {{-- Hiển thị lỗi chung (ngoại trừ lỗi của form mật khẩu) --}}
                    @if( $errors->any() && !$errors->has('current_password') && !$errors->has('new_password'))
                        <div class="alert alert-danger" role="alert">
                            <h6 class="alert-heading fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Vui lòng kiểm tra lại:</h6>
                            <ul class="mb-0">
                                @foreach( $errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('manager.account.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- PHẦN ẢNH ĐẠI DIỆN VÀ THÔNG TIN CƠ BẢN --}}
                        <div class="row align-items-center">
                            <div class="col-md-4 text-center mb-4 mb-md-0">
                                <label for="avatar" class="form-label fw-bold d-block mb-2">Ảnh đại diện</label>
                                <div class="avatar-preview-wrapper mx-auto" style="width: 120px;">
                                    <img id="avatar-preview"
                                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}"
                                         alt="Avatar" class="avatar-preview">
                                </div>
                                <label for="avatar" class="custom-file-upload mt-3">
                                    <i class="fas fa-upload me-2"></i>Chọn ảnh
                                </label>
                                <input type="file" id="avatar" name="avatar" accept="image/*" noscript="previewImage(event)">
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label fw-bold">Họ và Tên</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                           value="{{ old('first_name', $user->first_name) }}" placeholder="Ví dụ: Nguyễn Văn An" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold">Email đăng nhập</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="{{ old('email', $user->email) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-bold">Số điện thoại</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                           value="{{ old('phone', $user->phone) }}" placeholder="Nhập SĐT của bạn">
                                </div>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-sync-alt me-2"></i>Cập Nhật Thông Tin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            {{-- PHẦN 2: ĐỔI MẬT KHẨU (Bạn có thể thêm code phần này vào đây) --}}
            {{-- Ví dụ, bạn có thể include một view khác hoặc viết trực tiếp --}}
            {{-- @include('manager.account.partials.change-password-form') --}}
        </div>
    </div>
</div>
<script>
    // Hàm xem trước ảnh đại diện khi người dùng chọn file mới
    function previewImage(event) {
        const reader = new FileReader();
        reader.noscript = function(){
            const output = document.getElementById('avatar-preview');
            output.src = reader.result;
        };
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection
