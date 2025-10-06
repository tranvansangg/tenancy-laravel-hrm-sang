<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />

    <style>
        body {
            background: #f5f7fa;
            font-size: 16px;
        }
        .login-panel {
            margin-top: 80px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            padding: 30px 25px;
        }
        .login-panel .panel-heading {
            background: linear-gradient(90deg, #4f46e5, #3b82f6);
            color: #fff;
            text-align: center;
            padding: 25px;
        }
        .login-panel .panel-title {
            font-size: 26px;
            font-weight: bold;
            margin: 0;
        }
        .inner-addon {
            position: relative;
            margin-bottom: 20px;
        }
        .inner-addon i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
            font-size: 18px;
        }
        .inner-addon input {
            padding-left: 40px;
            height: 50px;
            font-size: 16px;
        }
        .btn-login {
            background: #4f46e5;
            color: #fff;
            font-weight: bold;
            border: none;
            padding: 14px;
            font-size: 18px;
            border-radius: 6px;
        }
        .btn-login:hover {
            background: #4338ca;
        }
        .checkbox label {
            font-size: 15px;
        }
        .extra-links {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            font-size: 15px;
        }
        .extra-links a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
        }
        .extra-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3"> <!-- mở rộng khung -->
            <div class="panel login-panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"> Đăng nhập hệ thống</h3>
                </div>
                <div class="panel-body">

                    {{-- Hiển thị lỗi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group inner-addon">
                            <i class="fa fa-envelope"></i>
                            <input type="email" name="email" class="form-control" placeholder="Nhập email..." required autofocus>
                        </div>

                        <div class="form-group inner-addon">
                            <i class="fa fa-lock"></i>
                            <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu..." required>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
                            </label>
                        </div>

                        <button type="submit" class="btn btn-login btn-block">Đăng nhập</button>

                        <div class="extra-links">
                            <a href="{{ route('password.forgot') }}">Quên mật khẩu?</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
