<?php

namespace Modules\Wallet\Repositories;

use Modules\Wallet\Models\Wallet;
use Modules\Wallet\Exceptions\InsufficientBalanceException;
use Modules\Wallet\Exceptions\InsufficientHeldBalanceException;

class WalletRepository implements WalletRepositoryInterface
{
    public function findById(int $id): Wallet
    {
        return Wallet::findOrFail($id);
    }

    public function updateBalance(int $id, float $amount): Wallet
    {
        $wallet = $this->findById($id);
        $wallet->balance += $amount;
        $wallet->save();
        return $wallet;
    }

    public function holdAmount(int $id, float $amount): Wallet
    {
        $wallet = $this->findById($id);
        
        if ($wallet->balance - $wallet->held_balance < $amount) {
            throw new InsufficientBalanceException();
        }
        
        $wallet->held_balance += $amount;
        $wallet->save();
        return $wallet;
    }

    public function releaseAmount(int $id, float $amount): Wallet
    {
        $wallet = $this->findById($id);
        
        if ($wallet->held_balance < $amount) {
            throw new InsufficientHeldBalanceException();
        }
        
        $wallet->held_balance -= $amount;
        $wallet->save();
        return $wallet;
    }

    public function processWithdrawal(int $id, float $amount): Wallet
    {
        $wallet = $this->findById($id);
        
        if ($wallet->held_balance < $amount) {
            throw new InsufficientHeldBalanceException();
        }
        
        if ($wallet->balance < $amount) {
            throw new InsufficientBalanceException();
        }
        
        $wallet->balance -= $amount;
        $wallet->held_balance -= $amount;
        $wallet->save();
        return $wallet;
    }
}