<?php

namespace App\Services\Contracts;

use App\Models\User;

interface AuthServiceInterface
{
    public function login(array $data);
    public function logout(User $user);
}
