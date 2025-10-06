@extends('employee.layouts.app')
@section('content')
<style>
    /* 
     * CSS Styling cho giao diện chỉnh sửa thông tin.
     * Bạn có thể tách phần này ra một file .css riêng để dễ quản lý hơn.
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
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #555;
    }
    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="file"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-sizing: border-box;
        transition: border-color 0.3s;
    }
    .form-group input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
    }
    .avatar-upload-group {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    
    .avatar-preview-wrapper {
        position: relative;
    }
    #avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%; /* Bo tròn ảnh đại diện */
        object-fit: cover;
        border: 3px solid #eee;
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
    }
    .btn-submit:hover {
        background-color: #0056b3;
    }
    /* Styling cho thông báo */
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
    <h2>Chỉnh sửa thông tin cá nhân</h2>
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
    <form action="{{ route('employee.account.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="first_name">Họ và Tên:</label>
            <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
        </div>
        <div class="form-group">
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="form-group">
            <label for="avatar">Ảnh đại diện:</label>
            <div class="avatar-upload-group">
                <div class="avatar-preview-wrapper">
                     {{-- Hiển thị ảnh cũ hoặc ảnh mặc định --}}
                    <img id="avatar-preview" src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://via.placeholder.com/120' }}" alt="avatar">
                </div>
                <input type="file" id="avatar" name="avatar" noscript="previewAvatar(event)">
            </div>
        </div>
        <button type="submit" class="btn-submit">Cập nhật thông tin</button>
    </form>
</div>
<script>
    // Hàm xem trước ảnh đại diện khi người dùng chọn file mới
    function previewAvatar(event) {
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
