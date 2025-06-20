<?php

namespace Modules\Wallet\Services;

use Modules\Wallet\Models\Wallet;
use Modules\Wallet\Exceptions\InsufficientBalanceException;
use Modules\Wallet\Exceptions\InsufficientHeldBalanceException;

interface WalletServiceInterface
{
    /**
     * Add balance to wallet
     * @throws \InvalidArgumentException When amount is not positive
     */
    public function addBalance(int $walletId, float $amount): Wallet;

    /**
     * Hold amount from available balance
     * @throws InsufficientBalanceException When insufficient available balance
     * @throws \InvalidArgumentException When amount is not positive
     */
    public function holdAmount(int $walletId, float $amount): Wallet;

    /**
     * Release held amount back to available balance
     * @throws InsufficientHeldBalanceException When insufficient held balance
     * @throws \InvalidArgumentException When amount is not positive
     */
    public function releaseAmount(int $walletId, float $amount): Wallet;

    /**
     * Process withdrawal (deduct from both balance and held balance)
     * @throws InsufficientBalanceException When insufficient total balance
     * @throws InsufficientHeldBalanceException When insufficient held balance
     * @throws \InvalidArgumentException When amount is not positive
     */
    public function processWithdrawal(int $walletId, float $amount): Wallet;

    /**
     * Get available balance (total balance minus held balance)
     */
    public function getAvailableBalance(int $walletId): float;
}