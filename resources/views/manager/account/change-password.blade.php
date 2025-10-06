@extends('manager.layouts.app')
@section('content')
<style>
    /* 
     * CSS Styling cho giao diện đổi mật khẩu.
     * Bạn có thể gộp chung vào file CSS của trang chỉnh sửa thông tin 
     * để tái sử dụng và dễ quản lý.
     */
    .account-form-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .account-form-container h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #333;
        font-weight: 600;
    }
    .form-group {
        margin-bottom: 20px;
        position: relative; /* Thêm position relative để định vị icon */
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #555;
    }
    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="password"] { /* Áp dụng style cho cả input password */
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-sizing: border-box;
        transition: border-color 0.3s;
        padding-right: 40px; /* Thêm padding để icon không đè lên chữ */
    }
    .form-group input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
    }
    
    /* Icon hiển thị/ẩn mật khẩu */
    .toggle-password {
        position: absolute;
        top: 40px; /* Điều chỉnh vị trí của icon */
        right: 10px;
        cursor: pointer;
        color: #888;
    }
    .btn-submit {
        display: block;
        width: 100%;
        padding: 14px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: background-color 0.3s;
        margin-top: 10px;
    }
    .btn-submit:hover {
        background-color: #0056b3;
    }
    /* Styling cho thông báo (giữ nguyên như cũ) */
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-size: 15px;
    }
    
    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
    }
    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
    }
    
    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }
</style>
<div class="account-form-container">
    <h2>Thay đổi mật khẩu</h2>
    {{-- Hiển thị thông báo thành công --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    {{-- Hiển thị thông báo lỗi --}}
    @if( $errors->any())
        <div class="alert alert-danger">
            <strong>Rất tiếc!</strong> Đã có lỗi xảy ra:
            <ul>
                @foreach( $errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('employee.account.changePassword') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="current_password">Mật khẩu hiện tại:</label>
            <input type="password" id="current_password" name="current_password" required>
            <i class="toggle-password" noscript="togglePasswordVisibility('current_password')">👁️</i>
        </div>
        <div class="form-group">
            <label for="new_password">Mật khẩu mới:</label>
            <input type="password" id="new_password" name="new_password" required>
            <i class="toggle-password" noscript="togglePasswordVisibility('new_password')">👁️</i>
        </div>
        <div class="form-group">
            <label for="new_password_confirmation">Xác nhận mật khẩu mới:</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
            <i class="toggle-password" noscript="togglePasswordVisibility('new_password_confirmation')">👁️</i>
        </div>
        <button type="submit" class="btn-submit">Đổi mật khẩu</button>
    </form>
</div>
<script>
    // Hàm để hiển thị hoặc ẩn mật khẩu
    function togglePasswordVisibility(fieldId) {
        const input = document.getElementById(fieldId);
        const icon = input.nextElementSibling; // Lấy icon ngay sau input
        
        if (input.type === "password") {
            input.type = "text";
            icon.textContent = '🙈'; // Thay đổi icon
        } else {
            input.type = "password";
            icon.textContent = '👁️'; // Trở về icon ban đầu
        }
    }
</script>
@endsection
