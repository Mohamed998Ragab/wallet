<?php

namespace Modules\ReferralCode\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReferralCodeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'status' => $this->used_by_user_id ? 'Used' : 'Active',
            'used_by' => $this->usedByUser ? [
                'name' => $this->usedByUser->name,
                'email' => $this->usedByUser->email,
                'date' => $this->updated_at->format('M d, Y H:i')
            ] : null,
            'created_at' => $this->created_at->format('M d, Y H:i'),
        ];
    }
}