<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->integer('month'); // tháng lương
            $table->integer('year');  // năm lương
            $table->integer('work_days')->default(0); // số ngày công thực tế
            $table->decimal('base_salary', 15, 2)->default(0); // từ Position.daily_salary * work_days
            $table->decimal('allowance', 15, 2)->default(0);   // phụ cấp
            $table->decimal('bonus', 15, 2)->default(0);       // khen thưởng
            $table->decimal('deduction', 15, 2)->default(0);   // khấu trừ (nghỉ không phép, đi muộn...)
            $table->decimal('insurance', 15, 2)->default(0);   // BHXH
            $table->decimal('net_salary', 15, 2)->default(0);  // lương thực lĩnh
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
}
