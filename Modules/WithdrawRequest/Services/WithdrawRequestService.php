<?php

namespace Modules\WithdrawRequest\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\WithdrawRequest\Repositories\WithdrawRequestRepositoryInterface;
use Modules\Wallet\Services\WalletServiceInterface;
use Modules\Transaction\Services\TransactionServiceInterface;
use App\Notifications\NewWithdrawalRequestNotification;
use Illuminate\Support\Facades\Notification;
use Modules\Admin\Models\Admin;
use Modules\WithdrawRequest\Models\WithdrawalRequest;

class WithdrawRequestService implements WithdrawRequestServiceInterface
{
    protected WithdrawRequestRepositoryInterface $withdrawRequestRepository;
    protected WalletServiceInterface $walletService;
    protected TransactionServiceInterface $transactionService;

    public function __construct(
        WithdrawRequestRepositoryInterface $withdrawRequestRepository,
        WalletServiceInterface $walletService,
        TransactionServiceInterface $transactionService
    ) {
        $this->withdrawRequestRepository = $withdrawRequestRepository;
        $this->walletService = $walletService;
        $this->transactionService = $transactionService;
    }

    public function create(int $adminId, float $amount): WithdrawalRequest
    {
        $admin = Admin::findOrFail($adminId);
        $this->walletService->holdAmount($admin->wallet_id, $amount);
        $request = $this->withdrawRequestRepository->create($adminId, $amount);
        Notification::send(Admin::all(), new NewWithdrawalRequestNotification($request));
        return $request;
    }

    public function all(): Collection
    {
        return $this->withdrawRequestRepository->all();
    }


    public function approve(int $id, int $adminId): void
{
    $request = $this->withdrawRequestRepository->findById($id);
    
    // Prevent self-approval
    if ($request->admin_id === $adminId) {
        throw new \Exception('You cannot approve your own withdrawal request');
    }

    $this->withdrawRequestRepository->approve($id, $adminId);
    $this->walletService->processWithdrawal($request->admin->wallet_id, $request->amount);
    $this->transactionService->recordTransaction(
        $request->admin->wallet_id,
        $request->amount,
        'withdrawal',
        $request->id,
        'withdrawal'
    );
}

    public function reject(int $id, int $adminId, string $reason): void
    {
        $request = $this->withdrawRequestRepository->reject($id, $adminId, $reason);
        $this->walletService->releaseAmount($request->admin->wallet_id, $request->amount);
    }
}