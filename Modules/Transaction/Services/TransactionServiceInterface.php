<?php

namespace Modules\Transaction\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\Transaction\Models\Transaction;

interface TransactionServiceInterface
{
    public function recordTransaction(int $walletId, float $amount, string $type, ?int $requestId = null, ?string $requestType = null): Transaction;
    public function getByWallet(int $walletId): Collection;
}