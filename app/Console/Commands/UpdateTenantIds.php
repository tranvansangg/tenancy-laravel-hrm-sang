<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class UpdateTenantIds extends Command
{
    protected $signature = 'tenant:update-all';
    protected $description = 'Cập nhật tenant_id cho tất cả bảng liên quan theo admin/tenant hiện tại';

    public function handle()
    {
        // Giả sử tenant admin muốn cập nhật là tenant_id = 3
        $tenantId = 3;

        // Cập nhật groups
        DB::table('groups')->whereNull('tenant_id')->update(['tenant_id' => $tenantId]);
        $this->info('Cập nhật tenant_id cho bảng groups xong.');

        // Cập nhật employees
        DB::table('employees')->whereNull('tenant_id')->update(['tenant_id' => $tenantId]);
        $this->info('Cập nhật tenant_id cho bảng employees xong.');

        // Cập nhật group_employee
        DB::table('group_employee')->whereNull('tenant_id')->update(['tenant_id' => $tenantId]);
        $this->info('Cập nhật tenant_id cho bảng group_employee xong.');

        $this->info('✅ Hoàn tất cập nhật tenant_id cho tất cả bảng.');
    }
}
