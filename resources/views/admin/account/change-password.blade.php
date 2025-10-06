@extends('admin.layouts.app')
@section('content')
{{-- CSS để giao diện thêm phần sống động --}}
<style>
    .password-card {
        transition: all 0.3s ease-in-out;
        border-radius: 12px;
    }
    .password-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12) !important;
    }
    .form-control-lg {
        font-size: 1.1rem;
        padding: 0.75rem 1.25rem;
    }
    .form-control:focus {
        border-color: #dc3545; /* Màu đỏ nguy hiểm của Bootstrap */
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }
    /* Style cho phần input group chứa icon xem mật khẩu */
    .input-group {
        position: relative;
    }
    .toggle-password-icon {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
        z-index: 100;
    }
    .toggle-password-icon i {
        font-size: 1.2rem;
    }
</style>
<div class="container py-4">
    {{-- Tiêu đề trang --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2"><i class="fas fa-key me-2"></i>Thay Đổi Mật Khẩu</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 password-card">
                <div class="card-header bg-danger text-white text-center">
                    <h3 class="font-weight-light my-3"><i class="fas fa-shield-alt me-2"></i>Bảo Mật Tài Khoản</h3>
                </div>
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
                            <h6 class="alert-heading fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Vui lòng kiểm tra lại:</h6>
                            <ul class="mb-0">
                                @foreach( $errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin.account.changePassword') }}" method="POST">
                        @csrf
                        {{-- Mật khẩu hiện tại --}}
                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-bold">Mật khẩu hiện tại</label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg" id="current_password" name="current_password" required placeholder="Nhập mật khẩu đang sử dụng">
                                <span class="toggle-password-icon" noscript="togglePasswordVisibility('current_password')">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        <hr class="my-4">
                        {{-- Mật khẩu mới --}}
                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-bold">Mật khẩu mới</label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg" id="new_password" name="new_password" required placeholder="Tối thiểu 8 ký tự">
                                <span class="toggle-password-icon" noscript="togglePasswordVisibility('new_password')">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        
                        {{-- Xác nhận mật khẩu mới --}}
                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label fw-bold">Xác nhận mật khẩu mới</label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg" id="new_password_confirmation" name="new_password_confirmation" required placeholder="Nhập lại chính xác mật khẩu mới">
                                <span class="toggle-password-icon" noscript="togglePasswordVisibility('new_password_confirmation')">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-danger btn-lg">
                                <i class="fas fa-save me-2"></i>Xác Nhận Thay Đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- JavaScript để xử lý hiển thị/ẩn mật khẩu --}}
<script>
    function togglePasswordVisibility(fieldId) {
        const input = document.getElementById(fieldId);
        const icon = input.nextElementSibling.querySelector('i');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection
