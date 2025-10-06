<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable extends Migration
{
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
           $table->unsignedBigInteger('tenant_id')->nullable()->index();
  $table->foreign('tenant_id')
                      ->references('id')
                      ->on('tenants')
                      ->onDelete('cascade');  
            $table->string('code');
                $table->unique(['tenant_id', 'code']);

            $table->string('name');
            $table->decimal('daily_salary', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('positions');
    }
}
