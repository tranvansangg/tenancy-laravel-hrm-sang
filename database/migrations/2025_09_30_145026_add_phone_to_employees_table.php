<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            // Thêm tenant_id nếu chưa có
         
            // Thêm cột phone
            $table->string('phone', 20)->nullable()->after('email');

            // Thêm unique theo tenant_id
            $table->unique(['tenant_id', 'phone']);
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            // Xóa unique
            $table->dropUnique(['tenant_id', 'phone']);
            
            // Xóa cột phone
            $table->dropColumn('phone');

            // Nếu muốn, cũng có thể drop tenant_id
            // $table->dropColumn('tenant_id');
        });
    }
};
