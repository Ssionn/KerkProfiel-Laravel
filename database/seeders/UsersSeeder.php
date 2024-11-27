<?php

namespace Database\Seeders;

use App\Models\User;
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
                'role_id' => 3,
                'team_id' => 1,
            ],
            [
                'username' => 'Andy Hoang',
                'email' => 'andy@houseofhope.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_id' => 3,
                'team_id' => 1,
            ],
            [
                'username' => 'Casper Kizewski',
                'email' => 'casper@houseofhope.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_id' => 2,
                'team_id' => 1,
            ],
            [
                'username' => 'Damian Van Zeelt',
                'email' => 'damian@houseofhope.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_id' => 3,
                'team_id' => 1,
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'username' => $user['username'],
                'email' => $user['email'],
                'password' => $user['password'],
                'email_verified_at' => now(),
                'role_id' => $user['role_id'],
                'team_id' => $user['team_id'],
            ]);
        }
    }
}
