<?php

namespace Modules\ReferralCode\Controllers;

use App\Http\Controllers\Controller;
use Modules\ReferralCode\Services\ReferralCodeServiceInterface;
use Illuminate\Support\Facades\Auth;
use Modules\ReferralCode\Resources\ReferralCodeResource;

class AdminReferralController extends Controller
{
    protected ReferralCodeServiceInterface $referralCodeService;

    public function __construct(ReferralCodeServiceInterface $referralCodeService)
    {
        $this->referralCodeService = $referralCodeService;
    }

    public function index()
    {
        try {
            $admin = Auth::guard('admin')->user();
            $allCodes = $this->referralCodeService->getAdminReferralCodes($admin->id);
            
            // Split codes into unused and used
            $unusedCodes = $allCodes->filter(fn($code) => !$code->used_by_user_id);
            $usedCodes = $allCodes->filter(fn($code) => $code->used_by_user_id);

            return view('admin::admin.referral.index', [
                'unusedCodes' => $unusedCodes,
                'usedCodes' => $usedCodes
            ]);
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to load referral codes: ' . $e->getMessage());
        }
    }

    public function generate()
    {
        try {
            $admin = Auth::guard('admin')->user();
            $referralCode = $this->referralCodeService->generate($admin->id, get_class($admin));
            
            return redirect()->route('admin.referral.index')
                ->with('success', "New referral code generated: {$referralCode->code}");
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to generate referral code: ' . $e->getMessage());
        }
    }
}