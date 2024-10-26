<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'username' => 'Ivano Baptista',
                'email' => 'ivano@houseofhope.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'username' => 'Andy Hoang',
                'email' => 'andy@houseofhope.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'username' => 'Casper Kizewski',
                'email' => 'casper@houseofhope.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        ];

        foreach ($users as $user) {
            User::create([
                'username' => $user['username'],
                'email' => $user['email'],
                'password' => $user['password'],
                'email_verified_at' => $user['email_verified_at']
            ]);
        }
    }
}
