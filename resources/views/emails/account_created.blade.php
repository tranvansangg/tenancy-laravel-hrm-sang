<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Tài Khoản Mới</title>
</head>
<body>
    <h2>Xin Chào {{$user->first_name}} {{$user ->last_name}},</h2>
    <p>Bạn đã được tạo thành công tài khoản trên hệ thống quản lý nhân sự của công ty ABC.</p>
    <p><b>Tên đăng nhập:</b> {{$user->email}}</p>
    <p><b>mật khẩu:</b> {{$password}}</p>
    <p>Vui lòng đăng nhập tại: <a href="{{url('/login')}}">{{url('/login')}}</a></p>
    <p>Hãy đổi mật khẩu sau khi đăng nhập để bảo mật tài khoản.</p>
    <p>Trân trọng,</p>
</body>
</html>