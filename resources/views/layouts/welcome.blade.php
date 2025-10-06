<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SANGTRAN INTERNATIONAL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; }
        .nav-link { font-weight: 600; }
        .banner img { width: 100%; height: 500px; object-fit: cover; }
        .section-title { text-align: center; margin: 40px 0; font-size: 2rem; font-weight: bold; }
        .page-new .card img { height: 200px; object-fit: cover; }
        footer { background: #222; color: #fff; padding: 50px 0; }
        footer a { color: #fff; text-decoration: none; }
        footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<!-- HEADER -->
<header class="bg-white shadow-sm">
    <div class="container d-flex justify-content-between align-items-center py-3">
        <div class="d-flex align-items-center">
            <span class="fw-bold text-dark fs-3 text-uppercase">SANGTRAN INTERNATIONAL</span>
        </div>
        <nav>
            <ul class="nav">
                <li class="nav-item"><a href="#" class="nav-link">GIỚI THIỆU CHUNG</a></li>
                <li class="nav-item"><a href="#" class="nav-link">TIN TỨC SỰ KIỆN</a></li>
                <li class="nav-item"><a href="{{ route('jobs.index')}}" class="nav-link">TUYỂN DỤNG</a></li>
                <li class="nav-item"><a href="{{ route('contacts.form')}}" class="nav-link">LIÊN HỆ</a></li>
                                <li class="nav-item"><a href="{{ route('login')}}" class="nav-link">CỔNG THÔNG TIN NHÂN VIÊN</a></li>


            </ul>
        </nav>
    </div>
</header>

<!-- BANNER -->


<!-- GIỚI THIỆU -->
<section id="gioithieu" class="py-5">
    <div class="container">
        <h2 class="section-title">SƠ LƯỢC VỀ CHÚNG TÔI</h2>
        <div class="row align-items-center">
            <div class="col-md-6">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veniam dignissimos eaque explicabo ullam autem sed laborum qui minima modi nostrum? Dicta, nulla? Nobis, hic quidem dicta fugit odit molestiae ipsa.</p>
                <a href="#" class="btn btn-primary">Xem thêm</a>
            </div>
            <div class="col-md-6">
                <img src="https://via.placeholder.com/400x300" class="img-fluid mb-2" alt="">
                <img src="https://via.placeholder.com/400x300" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</section>

<!-- TIN TỨC -->
<section id="tintuc" class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title">TIN TỨC SỰ KIỆN</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card">
                    <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="">
                    <div class="card-body">
                        <h5 class="card-title">Tiêu đề tin tức 1</h5>
                        <a href="#" class="btn btn-sm btn-primary">Xem thêm</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="">
                    <div class="card-body">
                        <h5 class="card-title">Tiêu đề tin tức 2</h5>
                        <a href="#" class="btn btn-sm btn-primary">Xem thêm</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="">
                    <div class="card-body">
                        <h5 class="card-title">Tiêu đề tin tức 3</h5>
                        <a href="#" class="btn btn-sm btn-primary">Xem thêm</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-start mt-3">
            <a href="#" class="btn btn-outline-secondary">Xem tất cả tin tức</a>
        </div>
    </div>
</section>

<!-- TUYỂN DỤNG -->
@yield('content')



<!-- FOOTER -->
<footer>
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-7">
                <h5>SANGTRAN INTERNATIONAL Co.,Ltd</h5>
                <p><i class="fas fa-location-arrow me-2"></i>Địa chỉ: 123 Đường ABC, Quận XYZ, TP.HCM</p>
                <p><i class="fas fa-phone me-2"></i>SĐT: 0123456789</p>
                <p><i class="fas fa-envelope me-2"></i>Email: info@sangtran.com</p>
            </div>
            <div class="col-md-5 text-md-end">
                <h5>CỘNG ĐỒNG</h5>
                <a href="#" class="me-2"><img src="http://stu.edu.vn/images/fb.png" alt="FB"></a>
                <a href="#" class="me-2"><img src="http://stu.edu.vn/images/twitter.png" alt="Twitter"></a>
                <a href="#"><img src="http://stu.edu.vn/images/youtube.png" alt="YouTube"></a>
            </div>
        </div>
        <div class="text-center">
            &copy; 2025 SANGTRAN INTERNATIONAL Co.,Ltd
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
