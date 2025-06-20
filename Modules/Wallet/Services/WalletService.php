<?php

namespace Modules\Wallet\Services;

use Modules\Wallet\Models\Wallet;
use Modules\Wallet\Repositories\WalletRepositoryInterface;
use Modules\Wallet\Exceptions\InsufficientBalanceException;
use Modules\Wallet\Exceptions\InsufficientHeldBalanceException;

class WalletService implements WalletServiceInterface
{
    protected $walletRepository;

    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function addBalance(int $walletId, float $amount): Wallet
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be greater than zero');
        }

        return $this->walletRepository->updateBalance($walletId, $amount);
    }

    public function holdAmount(int $walletId, float $amount): Wallet
    {
        $this->validateAmount($amount);
        
        try {
            return $this->walletRepository->holdAmount($walletId, $amount);
        } catch (InsufficientBalanceException $e) {
            $wallet = $this->walletRepository->findById($walletId);
            $available = $wallet->balance - $wallet->held_balance;
            throw new InsufficientBalanceException(
                "Cannot hold ${amount}. Available balance: ${available}"
            );
        }
    }

    public function releaseAmount(int $walletId, float $amount): Wallet
    {
        $this->validateAmount($amount);

        try {
            return $this->walletRepository->releaseAmount($walletId, $amount);
        } catch (InsufficientHeldBalanceException $e) {
            $held = $this->walletRepository->findById($walletId)->held_balance;
            throw new InsufficientHeldBalanceException(
                "Cannot release ${amount}. Held balance: ${held}"
            );
        }
    }

    public function processWithdrawal(int $walletId, float $amount): Wallet
    {
        $this->validateAmount($amount);

        try {
            return $this->walletRepository->processWithdrawal($walletId, $amount);
        } catch (InsufficientBalanceException $e) {
            $wallet = $this->walletRepository->findById($walletId);
            throw new InsufficientBalanceException(
                "Cannot withdraw ${amount}. Available: " . ($wallet->balance - $wallet->held_balance)
            );
        }
    }

    public function getAvailableBalance(int $walletId): float
    {
        $wallet = $this->walletRepository->findById($walletId);
        return $wallet->balance - $wallet->held_balance;
    }

    protected function validateAmount(float $amount): void
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be greater than zero');
        }
    }
}