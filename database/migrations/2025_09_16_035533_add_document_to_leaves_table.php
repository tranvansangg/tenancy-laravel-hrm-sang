<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->string('document')->nullable()->after('is_paid')->comment('File chứng nhận nghỉ phép (PDF/Ảnh)');
        });
    }

    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->dropColumn('document');
        });
    }
};
