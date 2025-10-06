<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('overtimes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('creator_id'); // trưởng phòng
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('reason');
            $table->unsignedBigInteger('approver_id')->nullable(); // admin duyệt
            $table->enum('status', ['pending','approved','declined'])->default('pending');
            $table->timestamps();

            // foreign key (nếu muốn)
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('creator_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('approver_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('overtimes');
    }
};
