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

    // public function getAdmin(int $id): Admin
    // {
    //     try {
    //         return $this->adminRepository->findById($id);
    //     } catch (\Exception $e) {
    //         throw new InvalidArgumentException('Admin not found.');
    //     }
    // }

    // public function updateProfile(int $id, array $data): Admin
    // {
    //     if (isset($data['password']) && !empty($data['password'])) {
    //         $data['password'] = Hash::make($data['password']);
    //     } else {
    //         unset($data['password']);
    //     }

    //     try {
    //         return $this->adminRepository->update($id, $data);
    //     } catch (\Exception $e) {
    //         throw new InvalidArgumentException('Failed to update profile: ' . $e->getMessage());
    //     }
    // }
}
