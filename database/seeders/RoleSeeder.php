<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        echo "Seeding Proses: Role\n";

        try {
            $roles = ['ADMIN', 'USER'];

            foreach ($roles as $role) {
                Role::updateOrCreate(
                    ['name' => $role],
                    ['id' => Str::uuid(), 'is_active' => true]
                );
            }

            echo "Seeding Completed: Role\n";
        } catch (\Throwable $e) {
            echo 'Seeding Error: Role - ' . $e->getMessage() . "\n";
        }
    }
}
