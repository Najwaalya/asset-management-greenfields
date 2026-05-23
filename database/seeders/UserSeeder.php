<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin1234'),
            'role'     => 'admin',
        ]);

        User::create([
            'name' => 'Operator',
            'email' => 'operator@gmail.com',
            'password' => Hash::make('operator1234'),
            'role'     => 'operator',
        ]);

        User::create([
            'name' => 'Teknisi',
            'email' => 'teknisi@gmail.com',
            'password' => Hash::make('teknisi1234'),
            'role'     => 'teknisi',
        ]);
    }
}