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
 Schema::create('groups', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // Tên nhóm
    $table->enum('type',['project','department']); // Loại nhóm
    $table->foreignId('leader_id')->constrained('employees')->onDelete('cascade'); // Leader
    $table->enum('status',['active','inactive'])->default('active'); // Trạng thái
    $table->text('description')->nullable(); // Mô tả nhóm
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
