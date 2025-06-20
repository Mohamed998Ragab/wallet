<?php

namespace Modules\ReferralCode\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\ReferralCode\Models\ReferralCode;
use Modules\Admin\Models\Admin;

interface ReferralCodeServiceInterface
{
    public function generate(int $generatorId, string $generatorType): ReferralCode;
    public function useReferralCode(string $code, int $userId): ?ReferralCode;
    public function getAdminReferralCodes(int $adminId): Collection;
    public function getActiveAdminReferralCode(int $adminId): ?ReferralCode;
    public function findByCode(string $code): ?ReferralCode;

    public function useCode(string $code, int $userId): ?ReferralCode;  // Add this
    public function getActiveByGenerator(int $generatorId, string $generatorType): ?ReferralCode;

}