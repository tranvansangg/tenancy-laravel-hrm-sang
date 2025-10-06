<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('job_id')  // Liên kết với bảng jobs
                  ->constrained('jobs')
                  ->onDelete('cascade');
            
            $table->string('applicant_name');   // Tên người nộp
            $table->string('email');            // Email liên hệ
            $table->string('phone')->nullable(); // Số điện thoại (tùy chọn)
            $table->text('cv_file')->nullable(); // Đường dẫn file CV
            $table->text('cover_letter')->nullable(); // Thư xin việc (tùy chọn)
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
