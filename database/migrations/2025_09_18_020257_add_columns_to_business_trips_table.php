<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBusinessTripsTable extends Migration
{
    public function up()
    {
        Schema::table('business_trips', function (Blueprint $table) {
            // Người yêu cầu/cử đi
            $table->foreignId('requested_by')
                  ->nullable()
                  ->after('employee_id')
                  ->constrained('employees')
                  ->nullOnDelete();

            // Chi phí
            $table->decimal('estimated_cost', 15, 2)
                  ->default(0)
                  ->after('notes');
            $table->decimal('actual_cost', 15, 2)
                  ->nullable()
                  ->after('estimated_cost');

            // Báo cáo công tác
            $table->text('report')->nullable()->after('actual_cost');

            // Trạng thái
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])
                  ->default('pending')
                  ->after('report');
        });
    }

    public function down()
    {
        Schema::table('business_trips', function (Blueprint $table) {
            $table->dropForeign(['requested_by']);
            $table->dropColumn(['requested_by', 'estimated_cost', 'actual_cost', 'report', 'status']);
        });
    }
}
