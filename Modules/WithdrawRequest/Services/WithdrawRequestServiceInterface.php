<?php

namespace Modules\WithdrawRequest\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\WithdrawRequest\Models\WithdrawalRequest;

interface WithdrawRequestServiceInterface
{
    public function create(int $adminId, float $amount): WithdrawalRequest;
    public function all(): Collection;
    public function approve(int $id, int $adminId): void;
    public function reject(int $id, int $adminId, string $reason): void;
}