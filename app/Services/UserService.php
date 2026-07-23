<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\Contracts\UserServiceInterface;

class UserService implements UserServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return $user;
    }

    public function updateUser(User $user, array $data)
    {

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return $user;
    }
}
