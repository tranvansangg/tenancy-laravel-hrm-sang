<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Xóa foreign key cũ
            $table->dropForeign(['employee_id']);

            // Thêm lại với onDelete cascade
            $table->foreign('employee_id')
                  ->references('id')->on('employees')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            
            // Thêm lại foreign key mặc định (không cascade)
            $table->foreign('employee_id')
                  ->references('id')->on('employees');
        });
    }
};
