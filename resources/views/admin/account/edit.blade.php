@extends('admin.layouts.app')
@section('content')
{{-- CSS không thay đổi, giữ nguyên như phiên bản trước --}}
<style>
    .profile-card {
        transition: all 0.3s ease-in-out;
        border-radius: 12px;
    }
    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12) !important;
    }
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    /* === Cải tiến phần Avatar === */
    .avatar-upload-wrapper {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto;
        cursor: pointer;
    }
    .avatar-preview {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
    }
    .avatar-upload-wrapper:hover .avatar-preview {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }
    .avatar-upload-wrapper .upload-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.3s ease;
        font-size: 2rem;
    }
    .avatar-upload-wrapper:hover .upload-overlay {
        opacity: 1;
    }
    #avatar {
        display: none;
    }
</style>
<div class="container py-4">
    {{-- Tiêu đề trang --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2"><i class="fas fa-user-cog me-2"></i>Chỉnh Sửa Tài Khoản</h1>
    </div>
    <div class="card shadow-lg border-0 profile-card">
        <div class="card-body p-4 p-md-5">
            {{-- Thông báo --}}
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif
            @if( $errors->any())
                <div class="alert alert-danger" role="alert">
                    <h6 class="alert-heading fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Vui lòng kiểm tra lại thông tin:</h6>
                    <ul class="mb-0">
                        @foreach( $errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.account.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row align-items-center">
                    {{-- CỘT BÊN TRÁI: AVATAR --}}
                    <div class="col-md-4 text-center mb-4 mb-md-0">
                        <div class="fw-bold d-block mb-3">Ảnh đại diện</div>
                        
                        {{-- SỬA LỖI TẠI ĐÂY --}}
                        <label for="avatar" class="avatar-upload-wrapper">
                            <img id="avatar-preview" src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('images/default-avatar.png') }}" alt="Avatar" class="avatar-preview">
                            <div class="upload-overlay">
                                <i class="fas fa-camera"></i>
                            </div>
                        </label>
                        {{-- Kết thúc phần sửa lỗi --}}
                        <input type="file" name="avatar" id="avatar" accept="image/*" noscript="previewImage(event)">
                    </div>
                    {{-- CỘT BÊN PHẢI: THÔNG TIN CHI TIẾT --}}
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="first_name" class="form-label fw-bold">Họ và Tên</label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" class="form-control form-control-lg" placeholder="Ví dụ: Nguyễn Văn An">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control form-control-lg @error('email') is-invalid @enderror" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Số điện thoại</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="form-control form-control-lg" placeholder="Nhập SĐT của bạn">
                        </div>
                    </div>
                </div>
                <div class="d-grid mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Lưu thay đổi
                    </button>
                </div>
            </form>
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
