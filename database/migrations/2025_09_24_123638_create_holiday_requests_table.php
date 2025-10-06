<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('holiday_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');    // Nhân viên tạo đơn
            $table->unsignedBigInteger('department_id');  // Phòng ban
            $table->unsignedBigInteger('holiday_id');     // Ngày lễ
            $table->text('reason')->nullable();           // Lý do
            $table->enum('status', [
                'pending_manager',
                'pending_admin',
                'approved',
                'rejected_manager',
                'rejected'
            ])->default('pending_manager');
            $table->unsignedBigInteger('manager_id')->nullable(); // Trưởng phòng duyệt
            $table->unsignedBigInteger('admin_id')->nullable();   // Admin duyệt
            $table->decimal('working_hours', 5, 2)->default(8);   // Số giờ công (mặc định 8h)
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('holiday_id')->references('id')->on('holidays')->onDelete('cascade');
            $table->foreign('manager_id')->references('id')->on('employees')->nullOnDelete();
            $table->foreign('admin_id')->references('id')->on('employees')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('holiday_requests');
    }
};
