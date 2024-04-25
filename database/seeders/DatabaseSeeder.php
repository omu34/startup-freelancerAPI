<?php

namespace Database\Seeders;

use App\Models\User;
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

        // Create an admin user
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'bernard@belvadigital.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true,
        ]);
    }
}
