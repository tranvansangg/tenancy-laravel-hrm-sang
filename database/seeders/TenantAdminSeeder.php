<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TenantAdminSeeder extends Seeder
{
    public function run()
    {
        // 1️⃣ Tạo tenant
        $tenantId = DB::table('tenants')->insertGetId([
            'name'       => 'Công ty ABC chính',
            'data'       => json_encode([]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2️⃣ Tạo domain
        DB::table('domains')->insert([
            'domain'     => '127.0.0.1',
            'tenant_id'  => $tenantId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3️⃣ Tạo admin
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name'  => 'ABC',
            'email'      => 'ajaxla31@gmail.com',
            'password'   => Hash::make('adminadmin'),
                        'phone'      => '0123456789',

            'role'       => 'admin',
            'tenant_id'  => $tenantId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info("Tenant 127.0.0.1 và admin đã tạo xong!");
    }
}
