<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration {
    public function up() {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->enum('leave_type', ['annual','sick','maternity','unpaid','other'])->default('annual');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('days', 5,2);
            $table->enum('status', ['pending','approved','rejected'])->default('pending');
            $table->boolean('is_paid')->default(true); // nghỉ có lương hay không
            $table->unsignedBigInteger('approved_by')->nullable(); // ai duyệt
            $table->text('reason')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down() {
        Schema::dropIfExists('leaves');
    }
}
