<?php

namespace Modules\User\Services;

use Modules\User\Models\User;

interface UserServiceInterface
{
    public function register(array $data): User;
    public function login(array $data): array; 
}