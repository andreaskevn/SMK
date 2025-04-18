<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            User::create([
                'users_name' => "Siswa $i",
                'users_email' => "siswa$i@example.com",
                'id_role' => 1,
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]);
        }

        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'users_name' => "Guru $i",
                'users_email' => "guru$i@example.com",
                'id_role' => 2,
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]);
        }

        User::create([
            'users_name' => "Admin",
            'users_email' => "admin@example.com",
            'id_role' => 3,
            'password' => Hash::make('admin123'),
            'remember_token' => Str::random(10),
        ]);
    }
}
