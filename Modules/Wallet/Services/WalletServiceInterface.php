<?php

namespace Modules\Wallet\Services;

use Modules\Wallet\Models\Wallet;
use Modules\Wallet\Exceptions\InsufficientBalanceException;
use Modules\Wallet\Exceptions\InsufficientHeldBalanceException;

interface WalletServiceInterface
{

    public function addBalance(int $walletId, float $amount): Wallet;


    public function holdAmount(int $walletId, float $amount): Wallet;


    public function releaseAmount(int $walletId, float $amount): Wallet;


    public function processWithdrawal(int $walletId, float $amount): Wallet;


    public function getAvailableBalance(int $walletId): float;
}
