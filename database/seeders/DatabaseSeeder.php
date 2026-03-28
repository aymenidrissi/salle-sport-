<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(ProgramSeeder::class);

        $clientRole = Role::query()->where('slug', 'client')->first();
        $adminRole = Role::query()->where('slug', 'admin')->first();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role_id' => $clientRole?->id,
        ]);

        User::query()->firstOrCreate(
            ['email' => 'admin@athleticore.test'],
            [
                'name' => 'Admin Athleticore',
                'password' => Hash::make('password'),
                'role_id' => $adminRole?->id,
            ]
        );
    }
}
