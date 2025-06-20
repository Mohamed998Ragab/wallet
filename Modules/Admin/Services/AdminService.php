<?php

namespace Modules\Admin\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Admin\Repositories\AdminRepositoryInterface;
use Modules\Admin\Services\AdminServiceInterface;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;
use Modules\Admin\Models\Admin;

class AdminService implements AdminServiceInterface
{
    protected $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function authenticate(array $credentials): bool
    {
        $admin = $this->adminRepository->findByEmail($credentials['email']);
        return $admin && password_verify($credentials['password'], $admin->password);
    }

}
