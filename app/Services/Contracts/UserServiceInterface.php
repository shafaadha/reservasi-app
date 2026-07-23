<?php

namespace App\Services\Contracts;

use App\Models\User;

interface UserServiceInterface
{
    // create new user
    public function createUser(array $data);

    //update an existing user
    public function updateUser(User $user, array $data);
}
