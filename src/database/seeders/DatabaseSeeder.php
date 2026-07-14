<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Owner
        User::factory()->create([
            'name' => 'Owner Claps',
            'email' => 'owner@clapscoffee.com',
            'password' => 'password123',
            'role' => 'owner',
        ]);

        // Karyawan
        User::factory()->create([
            'name' => 'Karyawan Claps',
            'email' => 'karyawan@clapscoffee.com',
            'password' => 'password123',
            'role' => 'karyawan',
        ]);

        // Customer
        User::factory()->create([
            'name' => 'Coffee Lover',
            'email' => 'customer@clapscoffee.com',
            'password' => 'password123',
            'role' => 'customer',
        ]);

        $this->call(DummyDataSeeder::class);
    }
}
