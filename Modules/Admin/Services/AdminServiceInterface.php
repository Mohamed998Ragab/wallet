<?php

namespace Modules\Admin\Services;

interface AdminServiceInterface
{
    public function authenticate(array $credentials): bool;
}