<?php

namespace Modules\Transaction\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Transaction\Models\Transaction;

interface TransactionRepositoryInterface
{
    public function create(array $data): Transaction;
    public function getByWallet(int $walletId): Collection;
}