<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Ngày tham gia BHXH tại công ty
            $table->date('bhxh_join_date')->nullable()->comment('Ngày tham gia BHXH tại công ty');
            
            // Trạng thái tham gia BHXH: 0=Chưa, 1=Đang, 2=Ngừng
            $table->tinyInteger('bhxh_participation_status')->default(0)
                  ->comment('Trạng thái tham gia BHXH: 0=Chưa, 1=Đang, 2=Ngừng');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['bhxh_join_date', 'bhxh_participation_status']);
        });
    }
};
