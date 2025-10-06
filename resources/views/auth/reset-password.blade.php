<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />

    <style>
        body {
            background: #f5f7fa;
            font-size: 16px;
        }
        .reset-panel {
            margin-top: 100px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            padding: 30px 25px;
        }
        .reset-panel .panel-heading {
            background: linear-gradient(90deg, #f59e0b, #d97706);
            color: #fff;
            text-align: center;
            padding: 25px;
        }
        .reset-panel .panel-title {
            font-size: 24px;
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
        .btn-reset {
            background: #f59e0b;
            color: #fff;
            font-weight: bold;
            border: none;
            padding: 14px;
            font-size: 18px;
            border-radius: 6px;
        }
        .btn-reset:hover {
            background: #d97706;
        }
        .extra-links {
            margin-top: 20px;
            text-align: center;
            font-size: 15px;
        }
        .extra-links a {
            color: #f59e0b;
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
        <div class="col-md-6 col-md-offset-3">
            <div class="panel reset-panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-lock"></i> Đổi mật khẩu</h3>
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

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="form-group inner-addon">
                            <i class="fa fa-key"></i>
                            <input type="password" name="password" class="form-control" placeholder="Mật khẩu mới" required>
                        </div>

                        <div class="form-group inner-addon">
                            <i class="fa fa-check"></i>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu" required>
                        </div>

                        <button type="submit" class="btn btn-reset btn-block">Đổi mật khẩu</button>
                    </form>

                    <div class="extra-links">
                        <a href="{{ route('login') }}"><i class="fa fa-arrow-left"></i> Quay lại đăng nhập</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
