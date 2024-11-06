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

        $user->guestify();

        return $user;
    }

    public function findUserById(int $id): User
    {
        return User::find($id);
    }

    public function makeUserActive(int $id): User
    {
        $user = $this->findUserById($id);

        $user->is_active = true;

        $user->save();

        return $user;
    }

    public function makeUserInactive(int $id): User
    {
        $user = $this->findUserById($id);

        $user->is_active = false;

        $user->save();

        return $user;
    }
}
