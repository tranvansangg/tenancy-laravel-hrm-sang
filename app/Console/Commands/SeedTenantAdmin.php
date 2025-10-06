<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SeedTenantAdmin extends Command
{
    protected $signature = 'tenant:seed-admin {tenant_id}';
    protected $description = 'Tạo admin cho tenant cụ thể';

    public function handle()
    {
        $tenantId = $this->argument('tenant_id');

        Session::put('tenant_id', $tenantId);

        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name' => strtoupper($tenantId),
            'email' => 'admin@' . $tenantId . '.local',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'tenant_id' => $tenantId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Session::forget('tenant_id');

        $this->info("Admin cho tenant $tenantId đã tạo xong!");
    }
}
