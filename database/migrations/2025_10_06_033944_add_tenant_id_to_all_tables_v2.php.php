<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTenantIdToAllTablesV2 extends Migration
{
    protected $tables = [
        'allowances','attendances','bonuses','business_trips','contacts','disciplines','holidays','holiday_requests','insurance_records','jobs','job_applications',
        'groups','leaves','maternity_leaves','overtimes','overtime_employee','payrolls','salary_templates'
    ];

    public function up()
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->unsignedBigInteger('tenant_id')->after('id')->nullable()->index();
  $table->foreign('tenant_id')
                      ->references('id')
                      ->on('tenants')
                      ->onDelete('cascade');    
            });        }
    }

    public function down()
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('tenant_id');
            });
        }
    }
}