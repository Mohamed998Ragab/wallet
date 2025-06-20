<?php

namespace Modules\WithdrawRequest\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\WithdrawRequest\Models\WithdrawalRequest;

class WithdrawRequestRepository implements WithdrawRequestRepositoryInterface
{
    public function create(int $adminId, float $amount): WithdrawalRequest
    {
        return WithdrawalRequest::create([
            'admin_id' => $adminId,
            'amount' => $amount,
            'status' => 'pending',
        ]);
    }

    public function all(): Collection
    {
        return WithdrawalRequest::with('admin','approvedByAdmin')->get();
    }

    public function findById(int $id): WithdrawalRequest
    {
        return WithdrawalRequest::findOrFail($id);
    }

    public function approve(int $id, int $adminId): WithdrawalRequest
    {
        $request = $this->findById($id);
        $request->update([
            'status' => 'approved',
            'approved_by_admin_id' => $adminId,
            'processed_at' => now(),
        ]);
        return $request;
    }

    public function reject(int $id, int $adminId, string $reason): WithdrawalRequest
    {
        $request = $this->findById($id);
        $request->update([
            'status' => 'rejected',
            'approved_by_admin_id' => $adminId,
            'rejection_reason' => $reason,
            'processed_at' => now(),
        ]);
        return $request;
    }
}