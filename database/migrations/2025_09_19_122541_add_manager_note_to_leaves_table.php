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
    Schema::table('leaves', function (Blueprint $table) {
        $table->text('manager_note')->nullable()->after('reason');
    });
}

public function down()
{
    Schema::table('leaves', function (Blueprint $table) {
        $table->dropColumn('manager_note');
    });
}

};
