<?php

namespace Modules\Admin\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Wallet\Resources\WalletResource;

class AdminResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'wallet' => new WalletResource($this->whenLoaded('wallet')),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}