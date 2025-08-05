<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        echo "Seeding Proses: User\n";

        try {
            $adminRole = Role::where('name', 'ADMIN')->first();
            $customerRole = Role::where('name', 'USER')->first();

            User::updateOrCreate(
                ['email' => 'admin@kotakin.id'],
                [
                    'id' => Str::uuid(),
                    'name' => 'Admin',
                    'password' => Hash::make('password'),
                    'role_id' => $adminRole->id,
                    'is_active' => true,
                ]
            );

            User::updateOrCreate(
                ['email' => 'user@kotakin.id'],
                [
                    'id' => Str::uuid(),
                    'name' => 'Customer',
                    'password' => Hash::make('password'),
                    'role_id' => $customerRole->id,
                    'is_active' => true,
                ]
            );

            echo "Seeding Completed: User\n";
        } catch (\Throwable $e) {
            echo 'Seeding Error: User - ' . $e->getMessage() . "\n";
        }
    }
}
