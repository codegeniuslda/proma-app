<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@pm.com'],
            [
                'name' => 'admin',
                'password' => 'Proma2026',
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'Manager@pm.com'],
            [
                'name' => 'Manager',
                'password' => 'Proma1234',
                'role' => 'user',
            ]
        );
    }
}