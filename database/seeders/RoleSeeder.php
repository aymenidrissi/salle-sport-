<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::query()->firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Administrateur']
        );
        Role::query()->firstOrCreate(
            ['slug' => 'client'],
            ['name' => 'Client']
        );
    }
}
