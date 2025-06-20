<?php

namespace Modules\TopUpRequest\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\TopUpRequest\Models\TopUpRequest;

class TopUpRequestRepository implements TopUpRequestRepositoryInterface
{
    public function create(int $userId, float $amount): TopUpRequest
    {
        return TopUpRequest::create([
            'user_id' => $userId,
            'amount' => $amount,
            'status' => 'pending',
        ]);
    }

    public function all(): Collection
    {
        return TopUpRequest::with('user')->get();
    }

    public function findById(int $id): TopUpRequest
    {
        return TopUpRequest::findOrFail($id);
    }

    public function approve(int $id, int $adminId): TopUpRequest
    {
        $request = $this->findById($id);
        $request->update([
            'status' => 'approved',
            'approved_by_admin_id' => $adminId,
            'processed_at' => now(),
        ]);
        return $request;
    }

    public function reject(int $id, int $adminId, string $reason): TopUpRequest
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

    public function getUserRequests(int $userId, ?string $status = null): Collection
    {
        $query = TopUpRequest::with(['user', 'approvedByAdmin'])
            ->where('user_id', $userId)
            ->latest();
        
        if ($status) {
            $query->where('status', $status);
        }
        
        return $query->get();
    }
}