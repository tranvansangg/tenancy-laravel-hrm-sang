<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTypesTable extends Migration
{
    public function up()
    {
        Schema::create('employee_types', function (Blueprint $table) {
            $table->id();
           $table->unsignedBigInteger('tenant_id')->nullable()->index();
  $table->foreign('tenant_id')
                      ->references('id')
                      ->on('tenants')
                      ->onDelete('cascade');  
            $table->string('code');
            $table->unique(['tenant_id', 'code']); // tạo unique theo tenant
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_types');
    }
}
