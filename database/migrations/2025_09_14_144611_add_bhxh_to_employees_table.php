<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->boolean('bhxh_status')->default(true)->after('status'); // Có tham gia BHXH hay không
            $table->string('bhxh_code')->nullable()->after('bhxh_status'); // Mã BHXH nếu có
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['bhxh_status', 'bhxh_code']);
        });
    }
};
