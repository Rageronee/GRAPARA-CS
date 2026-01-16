<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Counter;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Services
        Service::create(['name' => 'Customer Service', 'code' => 'A']);
        Service::create(['name' => 'Teller', 'code' => 'B']);
        Service::create(['name' => 'Pengaduan', 'code' => 'C']);

        // Create Counters
        Counter::create(['name' => 'Counter 1', 'is_active' => true]);
        Counter::create(['name' => 'Counter 2', 'is_active' => true]);
        Counter::create(['name' => 'Counter 3', 'is_active' => true]);

        // Create Users (Admin, CS, Manager)
        User::create([
            'name' => 'Super Admin',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Afnan CS',
            'username' => 'afnan',
            'role' => 'cs',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Faris Manager',
            'username' => 'faris',
            'role' => 'manager',
            'password' => Hash::make('password'),
        ]);
    }
}
