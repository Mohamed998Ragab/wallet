<?php

namespace Modules\ReferralCode\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\ReferralCode\Models\ReferralCode;
use Modules\ReferralCode\Repositories\ReferralCodeRepositoryInterface;
use Modules\Admin\Models\Admin;

class ReferralCodeService implements ReferralCodeServiceInterface
{
    protected ReferralCodeRepositoryInterface $referralCodeRepository;

    public function __construct(ReferralCodeRepositoryInterface $referralCodeRepository)
    {
        $this->referralCodeRepository = $referralCodeRepository;
    }

    public function generate(int $generatorId, string $generatorType): ReferralCode
    {
        return $this->referralCodeRepository->create($generatorId, $generatorType);
    }

    public function useReferralCode(string $code, int $userId): ?ReferralCode
    {
        return $this->referralCodeRepository->useCode($code, $userId);
    }

    public function getAdminReferralCodes(int $adminId): Collection
    {
        return $this->referralCodeRepository->getByGenerator($adminId, Admin::class);
    }

    public function getActiveAdminReferralCode(int $adminId): ?ReferralCode
    {
        return $this->referralCodeRepository->getActiveByGenerator($adminId, Admin::class);
    }

    public function findByCode(string $code): ?ReferralCode
    {
        return $this->referralCodeRepository->findByCode($code);
    }

    public function useCode(string $code, int $userId): ?ReferralCode
    {
        return $this->referralCodeRepository->useCode($code, $userId);
    }

    public function getActiveByGenerator(int $generatorId, string $generatorType): ?ReferralCode
    {
        return $this->referralCodeRepository->getActiveByGenerator($generatorId, $generatorType);
    }
}
