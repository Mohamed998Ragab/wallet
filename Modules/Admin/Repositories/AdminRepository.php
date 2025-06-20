<?php

namespace Modules\Admin\Repositories;

use Modules\Admin\Models\Admin;
use Modules\Admin\Repositories\AdminRepositoryInterface;

use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class AdminRepository implements AdminRepositoryInterface
{
    public function findById(int $id): ?Admin
    {
        return Admin::findOrFail($id);
    }

    public function findByEmail(string $email): ?Admin
    {
        return Admin::where('email', $email)->firstOrFail();
    }

}
