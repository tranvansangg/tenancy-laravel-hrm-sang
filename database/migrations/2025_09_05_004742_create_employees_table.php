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
     Schema::create('employees', function (Blueprint $table) {
    $table->id();
           $table->unsignedBigInteger('tenant_id')->nullable()->index();
  $table->foreign('tenant_id')
                      ->references('id')
                      ->on('tenants')
                      ->onDelete('cascade');  
    $table->string('employee_code');
        $table->unique(['tenant_id', 'employee_code']);

    $table->unsignedBigInteger('account_id')->nullable();
    $table->string('avatar')->nullable();
    $table->string('full_name');
    $table->string('email');
        $table->unique(['tenant_id', 'email']);

    $table->string('nickname')->nullable();
    $table->enum('gender', ['male','female','other'])->nullable();
    $table->date('birth_date')->nullable();
    $table->string('birth_place')->nullable();
    $table->string('cccd');
        $table->unique(['tenant_id', 'cccd']);  
    $table->date('cccd_issue_date')->nullable();
    $table->string('cccd_issue_place')->nullable();
    $table->string('nationality')->nullable();
    $table->string('religion')->nullable();
    $table->string('ethnicity')->nullable();
    $table->unsignedBigInteger('employee_type_id')->nullable();
    $table->unsignedBigInteger('degree_id')->nullable();
    $table->unsignedBigInteger('specialty_id')->nullable();
    $table->unsignedBigInteger('department_id')->nullable();
    $table->unsignedBigInteger('position_id')->nullable();
    $table->unsignedBigInteger('education_level_id')->nullable();
    $table->boolean('status')->default(1);
    $table->string('address_permanent')->nullable();
    $table->string('address_resident')->nullable();
    $table->string('temporary_address')->nullable();
    
    $table->timestamps();
    $table->softDeletes();

    // Foreign keys
    $table->foreign('account_id')->references('id')->on('users')->onDelete('set null');
    $table->foreign('employee_type_id')->references('id')->on('employee_types')->onDelete('set null');
    $table->foreign('degree_id')->references('id')->on('degrees')->onDelete('set null');
    $table->foreign('specialty_id')->references('id')->on('specialties')->onDelete('set null');
    $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
    $table->foreign('position_id')->references('id')->on('positions')->onDelete('set null');
    $table->foreign('education_level_id')->references('id')->on('education_levels')->onDelete('set null');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
