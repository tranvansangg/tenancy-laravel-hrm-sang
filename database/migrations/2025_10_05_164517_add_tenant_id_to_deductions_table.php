<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('deductions', function (Blueprint $table) {
        $table->unsignedBigInteger('tenant_id')->nullable()->after('id')->index();
  $table->foreign('tenant_id')
                      ->references('id')
                      ->on('tenants')
                      ->onDelete('cascade');  
    });
}

public function down()
{
    Schema::table('deductions', function (Blueprint $table) {
        $table->dropColumn('tenant_id');
    });
}

};
