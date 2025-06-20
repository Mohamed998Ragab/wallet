<?php

namespace Modules\WithdrawRequest\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\WithdrawRequest\Models\WithdrawalRequest;

interface WithdrawRequestRepositoryInterface
{
    public function create(int $adminId, float $amount): WithdrawalRequest;
    public function all(): Collection;
    public function findById(int $id): WithdrawalRequest;
    public function approve(int $id, int $adminId): WithdrawalRequest;
    public function reject(int $id, int $adminId, string $reason): WithdrawalRequest;
}