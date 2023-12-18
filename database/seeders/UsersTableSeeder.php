<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'phone' => '1234567890',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'phone' => '9876543210',
            'password' => Hash::make('password456'),
        ]);

    }
}