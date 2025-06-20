<?php

namespace Modules\ReferralCode\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\ReferralCode\Services\ReferralCodeServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ReferralCode\Resources\ReferralCodeResource;

class ReferralController extends Controller
{
    protected ReferralCodeServiceInterface $referralCodeService;

    public function __construct(ReferralCodeServiceInterface $referralCodeService)
    {
        $this->referralCodeService = $referralCodeService;
    }

    public function generate(Request $request): JsonResponse
    {
        $user = $request->user();

        $existingCode = $this->referralCodeService
            ->getActiveByGenerator($user->id, \Modules\User\Models\User::class);

        if ($existingCode) {
            return response()->json([
                'code' => $existingCode->code,
                'message' => 'You already have an active referral code'
            ]);
        }

        $referralCode = $this->referralCodeService->generate(
            $user->id,
            \Modules\User\Models\User::class
        );

        return response()->json([
            'code' => $referralCode->code,
            'message' => 'New referral code generated'
        ], 201);
    }
}
