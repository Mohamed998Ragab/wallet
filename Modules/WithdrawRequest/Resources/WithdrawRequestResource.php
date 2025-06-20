<?php

namespace Modules\WithdrawRequest\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawRequestResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'admin_id' => $this->admin_id,
            'admin_name' => $this->whenLoaded('admin', fn() => $this->admin->name ?? 'Deleted Admin', 'Unknown Admin'),
            'admin_email' => $this->whenLoaded('admin', fn() => $this->admin->email ?? '', ''),
            'amount' => $this->amount,
            'status' => $this->status,
            'approved_by_admin_id' => $this->approved_by_admin_id,
            'approved_by_admin_name' => $this->whenLoaded('approvedByAdmin', fn() => $this->approvedByAdmin->name ?? 'Deleted Admin', null),
            'rejection_reason' => $this->rejection_reason,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'processed_at' => $this->processed_at?->format('Y-m-d H:i:s'),
        ];
    }
}
