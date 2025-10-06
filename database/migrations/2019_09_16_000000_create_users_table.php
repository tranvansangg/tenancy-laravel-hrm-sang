<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
                   $table->unsignedBigInteger('tenant_id')->nullable()->index();
  $table->foreign('tenant_id')
                      ->references('id')
                      ->on('tenants')
                      ->onDelete('cascade');    
            $table->string('avatar')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name');
            $table->string('email');
            $table->unique(['tenant_id', 'email']);
            $table->string('password');
            $table->string('phone');
            $table->unique(['tenant_id', 'phone']);
            $table->enum('role', ['admin', 'employee'])->default('employee');
            $table->unsignedBigInteger('access_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
