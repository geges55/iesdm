<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Test User',
            'username' => 'testme',
            'nohp' => '080989999',
            'email' => 'testuser@example.com',
            'password' => Hash::make('password'), // Ganti dengan password yang aman
            'role' => 'pemohon', // Sesuaikan peran dengan proses bisnis Anda
        ]);
    }
}
