<?php

namespace Modules\ReferralCode\Repositories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use Modules\ReferralCode\Models\ReferralCode;

class ReferralCodeRepository implements ReferralCodeRepositoryInterface
{
    public function create(int $generatorId, string $generatorType): ReferralCode
    {
        // Map simple types to full class names
        $classMap = [
            'admin' => \Modules\Admin\Models\Admin::class,
            'user' => \Modules\User\Models\User::class
        ];
        
        $generatorType = $classMap[strtolower($generatorType)] ?? $generatorType;
        
        $code = Str::upper(Str::random(8));
        while (ReferralCode::where('code', $code)->exists()) {
            $code = Str::upper(Str::random(8));
        }
        
        return ReferralCode::create([
            'code' => $code,
            'generator_id' => $generatorId,
            'generator_type' => $generatorType,
        ]);
    }

    public function findByCode(string $code): ?ReferralCode
    {
        return ReferralCode::with('usedByUser')
            ->where('code', $code)
            ->first();
    }

    public function useCode(string $code, int $userId): ?ReferralCode
    {
        $referralCode = $this->findByCode($code);
        
        if ($referralCode && !$referralCode->used_by_user_id) {
            $referralCode->update([
                'used_by_user_id' => $userId,
                'updated_at' => now()
            ]);
            return $referralCode->fresh();
        }
        
        return null;
    }

    public function getByGenerator(int $generatorId, string $generatorType): Collection
    {
        return ReferralCode::with('usedByUser')
            ->where('generator_id', $generatorId)
            ->where('generator_type', $generatorType)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getActiveByGenerator(int $generatorId, string $generatorType): ?ReferralCode
    {
        return ReferralCode::where('generator_id', $generatorId)
            ->where('generator_type', $generatorType)
            ->whereNull('used_by_user_id')
            ->first();
    }
}