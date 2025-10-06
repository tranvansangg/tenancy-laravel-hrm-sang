<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('insurance_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('social_insurance_number')->nullable();
            $table->string('health_insurance_number')->nullable();
            $table->string('unemployment_insurance_number')->nullable();
            $table->date('participation_date'); // ngày tham gia BHXH
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active'); 
            // active = đang tham gia, inactive = đã nghỉ, suspended = tạm dừng
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('insurance_records');
    }
}
