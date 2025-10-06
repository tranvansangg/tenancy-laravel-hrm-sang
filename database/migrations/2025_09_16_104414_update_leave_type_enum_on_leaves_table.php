<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Thêm 'paternity' và 'compensatory' vào leave_type
        DB::statement("ALTER TABLE leaves MODIFY leave_type ENUM('annual','sick','maternity','paternity','unpaid','compensatory','other') DEFAULT 'annual'");
    }

    public function down(): void
    {
        // Nếu rollback, loại bỏ 2 giá trị mới (chỉ giữ giá trị cũ)
        DB::statement("ALTER TABLE leaves MODIFY leave_type ENUM('annual','sick','maternity','unpaid','other') DEFAULT 'annual'");
    }
};
