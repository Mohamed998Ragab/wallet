<?php

namespace Modules\ReferralCode\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\ReferralCode\Models\ReferralCode;

interface ReferralCodeRepositoryInterface
{
    public function create(int $generatorId, string $generatorType): ReferralCode;
    public function findByCode(string $code): ?ReferralCode;
    public function useCode(string $code, int $userId): ?ReferralCode;
    public function getByGenerator(int $generatorId, string $generatorType): Collection;
    public function getActiveByGenerator(int $generatorId, string $generatorType): ?ReferralCode;
}