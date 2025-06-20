<?php

namespace Modules\TopUpRequest\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\TopUpRequest\Models\TopUpRequest;

interface TopUpRequestServiceInterface
{
    public function create(int $userId, float $amount): TopUpRequest;
    public function all(): Collection;
    public function approve(int $id, int $adminId): void;
    public function reject(int $id, int $adminId, string $reason): void;

    public function getUserRequests(int $userId, ?string $status = null): Collection;

}