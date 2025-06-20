<?php

namespace Modules\TopUpRequest\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TopUpRequestResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'amount' => (float) $this->amount,
            'status' => $this->status,
            'approved_by_admin_id' => $this->approved_by_admin_id,
            'approved_by_admin_name' => $this->approvedByAdmin?->name,
            'rejection_reason' => $this->rejection_reason,
            'created_at' => $this->created_at,
            'processed_at' => $this->processed_at,
        ];
    }
}