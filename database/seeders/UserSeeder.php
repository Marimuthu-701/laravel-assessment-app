<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Marimuthu M',
            'email' => 'marimuthu.m@oclocksolutions.com',
            'password' => Hash::make('qwerty@2023!'),
        ]);
    }
}
