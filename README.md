- composer install
- cp .env.example .env
- php artisan key:generate
- tạo bảng DB_DATABASE=
- chạy php artisan migrate
- chạy 3 lệnh trên để tạo domains và tài khoản admin:
  + php artisan db:seed --class=TenantABC1Seeder
  +  php artisan db:seed --class=TenantAbcSeeder
  +   php artisan db:seed --class=TenantAdminSeeder
- tạo 3 doamins ảo
127.0.0.1 congtyabc1.local
127.0.0.1 congtyabc2.local
127.0.0.1 congtyabc3.local 
- admin: toàn quyền hệ thống 
- Trưởng phòng: quản lý nhân viên phòng
- Trưởng phòng của Phòng Kế Toán: tính lương toàn công ty, quản lý nhân viên phòng
- nhân viên: xem quyền lợi chế độ xem thông tin cần thiết 


