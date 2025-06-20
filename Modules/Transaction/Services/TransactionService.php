<?php

namespace Modules\Transaction\Services;

use Illuminate\Database\Eloquent\Collection;

use Modules\Transaction\Models\Transaction;
use Modules\Transaction\Repositories\TransactionRepositoryInterface;

class TransactionService implements TransactionServiceInterface
{
    protected TransactionRepositoryInterface $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function recordTransaction(int $walletId, float $amount, string $type, ?int $requestId = null, ?string $requestType = null): Transaction
    {
        return $this->transactionRepository->create([
            'wallet_id' => $walletId,
            'amount' => $amount,
            'type' => $type,
            'request_id' => $requestId,
            'request_type' => $requestType,
        ]);
    }

    public function getByWallet(int $walletId): Collection
    {
        return $this->transactionRepository->getByWallet($walletId);
    }
}
