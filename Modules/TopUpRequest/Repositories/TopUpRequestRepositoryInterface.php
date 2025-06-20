<?php

namespace Modules\TopUpRequest\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\TopUpRequest\Models\TopUpRequest;

interface TopUpRequestRepositoryInterface
{
    public function create(int $userId, float $amount): TopUpRequest;
    public function all(): Collection;
    public function findById(int $id): TopUpRequest;
    public function approve(int $id, int $adminId): TopUpRequest;
    public function reject(int $id, int $adminId, string $reason): TopUpRequest;

    public function getUserRequests(int $userId, ?string $status = null): Collection;

}