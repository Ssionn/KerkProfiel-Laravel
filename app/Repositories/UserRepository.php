<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function createUser(
        string $username,
        string $email,
        string $password
    ): User {
        $user = new User([
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $user->save();

        $user->guestify();

        return $user;
    }

    public function findUserById(int $id): User
    {
        return User::find($id);
    }
}
