<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
Schema::create('group_employee', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('group_id');
    $table->unsignedBigInteger('employee_id');
    $table->timestamp('joined_at')->nullable();
    $table->timestamp('exited_at')->nullable();
    $table->string('reason_exit')->nullable();
    $table->string('status_exit')->nullable();
    $table->timestamps();

    // FK chuẩn
    $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
    $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_employee');
    }
};
