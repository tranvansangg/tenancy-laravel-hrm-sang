<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TenantAbcSeeder extends Seeder
{
    public function run()
    {
        // 1️⃣ Tạo tenant
        $tenantId = DB::table('tenants')->insertGetId([
            'name'       => 'Công ty ABC 1',
            'data'       => json_encode([]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2️⃣ Tạo domain
        DB::table('domains')->insert([
            'domain'     => 'congtyabc1.local',
            'tenant_id'  => $tenantId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3️⃣ Tạo admin
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name'  => 'ABC1',
            'email'      => 'vansang912005@gmail.com',
            'password'   => Hash::make('adminadmin'),
                        'phone'      => '0123456789',

            'role'       => 'admin',
            'tenant_id'  => $tenantId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info("Tenant congtyabc1.local và admin đã tạo xong!");
    }
}
