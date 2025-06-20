<?php

namespace Modules\User\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;
use Modules\User\Repositories\UserRepositoryInterface;
use Modules\ReferralCode\Services\ReferralCodeServiceInterface;
use Modules\Wallet\Services\WalletServiceInterface;
use InvalidArgumentException;
use Modules\ReferralCode\Models\ReferralCode;
use Modules\Transaction\Services\TransactionServiceInterface;

class UserService implements UserServiceInterface
{
    protected UserRepositoryInterface $userRepository;
    protected ReferralCodeServiceInterface $referralCodeService;
    protected WalletServiceInterface $walletService;

    protected TransactionServiceInterface $transactionService;
    public function __construct(
        UserRepositoryInterface $userRepository,
        ReferralCodeServiceInterface $referralCodeService,
        WalletServiceInterface $walletService,
        TransactionServiceInterface $transactionService
    ) {
        $this->userRepository = $userRepository;
        $this->referralCodeService = $referralCodeService;
        $this->walletService = $walletService;
        $this->transactionService = $transactionService;
    }

    public function register(array $data): User
    {
        return DB::transaction(function () use ($data) {
            // Validate referral code first
            if (!empty($data['referral_code'])) {
                $referralCode = $this->referralCodeService->findByCode($data['referral_code']);
                
                if (!$referralCode) {
                    throw new \InvalidArgumentException('The referral code is invalid');
                }
                
                if ($referralCode->used_by_user_id) {
                    throw new \InvalidArgumentException('This referral code has already been used');
                }
            }
    
            $data['password'] = Hash::make($data['password']);
            $user = $this->userRepository->create($data);
    
            if (!empty($data['referral_code'])) {
                $this->referralCodeService->useCode($data['referral_code'], $user->id);
                $this->applyReferralBonuses($user, $referralCode);
            }
    
            return $user->fresh(['wallet']);
        });
    }
    public function login(array $data): array
    {
        $user = $this->userRepository->findByEmail($data['email']);
        
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new InvalidArgumentException('Invalid credentials.');
        }
        
        $token = $user->createToken('api-token')->plainTextToken;
        
        return [
            'token' => $token,
            'user' => $user->load('wallet')  // Eager load wallet relationship
        ];
    }


    protected function applyReferralBonuses(User $newUser, ReferralCode $referralCode): void
    {
        $bonusAmount = 10.00; // 10 EGP for both parties

        // Credit the new user
        $this->walletService->addBalance($newUser->wallet->id, $bonusAmount);
        $this->transactionService->recordTransaction(
            $newUser->wallet->id,
            $bonusAmount,
            'referral_bonus',
            $referralCode->id,
            'referral'
        );
        // Credit the referrer (admin or user)
        $generator = $referralCode->generator; // This works due to morphTo relationship

        if ($generator && $generator->wallet) {
            $this->walletService->addBalance($generator->wallet->id, $bonusAmount);
            $this->transactionService->recordTransaction(
                $generator->wallet->id,
                $bonusAmount,
                'referral_bonus',
                $referralCode->id,
                'referral'
            );
        }
    }
}
