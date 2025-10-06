<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisciplinesTable extends Migration
{
public function up()
{
Schema::create('disciplines', function (Blueprint $table) {
$table->id();
$table->string('decision_code')->unique();
$table->unsignedBigInteger('employee_id');
$table->string('type')->nullable(); // khiển trách, cảnh cáo...
$table->text('reason')->nullable();
$table->date('decision_date')->nullable();
$table->string('signed_by')->nullable();
$table->string('attachment')->nullable();
$table->timestamps();


$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
});
}


public function down()
{
Schema::dropIfExists('disciplines');
}
}