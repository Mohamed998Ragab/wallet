<?php

namespace Modules\Transaction\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Transaction\Models\Transaction;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function create(array $data): Transaction
    {
        return Transaction::create($data);
    }

    public function getByWallet(int $walletId): Collection
    {
        return Transaction::where('wallet_id', $walletId)->get();
    }
}