<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TenantABC1Seeder extends Seeder
{
    public function run()
    {
        // 1️⃣ Tạo tenant
        $tenantId = DB::table('tenants')->insertGetId([
            'name'       => 'Công ty ABC 2',
            'data'       => json_encode([]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2️⃣ Tạo domain
        DB::table('domains')->insert([
            'domain'     => 'congtyabc2.local',
            'tenant_id'  => $tenantId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3️⃣ Tạo admin
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name'  => 'ABC2',
            'email'      => 'vansang1022005@gmail.com',
            'password'   => Hash::make('adminadmin'),
            'phone'      => '0123456789',
            'role'       => 'admin',
            'tenant_id'  => $tenantId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info("Tenant congtyabc2.local và admin đã tạo xong!");
    }
}
