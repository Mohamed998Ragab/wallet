<?php

namespace Modules\TopUpRequest\Services;

use Illuminate\Database\Eloquent\Collection;

use Modules\TopUpRequest\Repositories\TopUpRequestRepositoryInterface;
use Modules\Wallet\Services\WalletServiceInterface;
use Modules\Transaction\Services\TransactionServiceInterface;
use App\Notifications\NewTopUpRequestNotification;
use Illuminate\Support\Facades\Notification;
use Modules\Admin\Models\Admin;
use Modules\TopUpRequest\Models\TopUpRequest;

class TopUpRequestService implements TopUpRequestServiceInterface
{
    protected TopUpRequestRepositoryInterface $topUpRequestRepository;
    protected WalletServiceInterface $walletService;
    protected TransactionServiceInterface $transactionService;

    public function __construct(
        TopUpRequestRepositoryInterface $topUpRequestRepository,
        WalletServiceInterface $walletService,
        TransactionServiceInterface $transactionService
    ) {
        $this->topUpRequestRepository = $topUpRequestRepository;
        $this->walletService = $walletService;
        $this->transactionService = $transactionService;
    }

    public function create(int $userId, float $amount): TopUpRequest
    {
        $request = $this->topUpRequestRepository->create($userId, $amount);
        Notification::send(Admin::all(), new NewTopUpRequestNotification($request));
        return $request;
    }

    public function all(): Collection
    {
        return $this->topUpRequestRepository->all();
    }


    public function approve(int $id, int $adminId): void
    {
        $request = $this->topUpRequestRepository->findById($id);
        
        $this->topUpRequestRepository->approve($id, $adminId);
        $this->walletService->addBalance($request->user->wallet_id, $request->amount);
        $this->transactionService->recordTransaction(
            $request->user->wallet_id,
            $request->amount,
            'top_up',
            $request->id,
            'top_up'
        );
    }

    public function reject(int $id, int $adminId, string $reason): void
    {
        $this->topUpRequestRepository->reject($id, $adminId, $reason);
    }

    public function getUserRequests(int $userId, ?string $status = null): Collection
{
    return $this->topUpRequestRepository->getUserRequests($userId, $status);
}
}
