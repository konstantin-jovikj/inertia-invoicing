<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      // Check if the default user already exists, to avoid duplicates
      if (!User::where('email', 'admin@admin.com')->exists()) {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('11111111'), // Use a secure password
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    }
}
