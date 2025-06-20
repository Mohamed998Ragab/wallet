<?php

namespace Modules\Wallet\Repositories;
use Modules\Wallet\Models\Wallet;

interface WalletRepositoryInterface
{
    public function findById(int $id): Wallet;
    public function updateBalance(int $id, float $amount): Wallet;
    public function holdAmount(int $id, float $amount): Wallet;
    public function releaseAmount(int $id, float $amount): Wallet;
    public function processWithdrawal(int $id, float $amount): Wallet;
}