<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('business_trips', function (Blueprint $table) {
            $table->text('admin_feedback')->nullable()->after('report');
        });
    }

    public function down(): void
    {
        Schema::table('business_trips', function (Blueprint $table) {
            $table->dropColumn('admin_feedback');
        });
    }
};
