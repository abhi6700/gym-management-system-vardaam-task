<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::create([
            'id' => 'tenant',
            'name' => 'Tenant',
        ]);
        $tenant->domains()->create([
            'domain' => 'tenant.localhost',
        ]);

        $tenant = Tenant::create([
            'id' => 'admin',
            'name' => 'Admin',
        ]);
        $tenant->domains()->create([
            'domain' => 'admin.localhost',
        ]);
    }
}
