<?php

namespace Modules\Admin\Repositories;

use Modules\Admin\Models\Admin;

interface AdminRepositoryInterface
{
    public function findByEmail(string $email): ?Admin;
    // public function findById(int $id);
    // public function all();
}