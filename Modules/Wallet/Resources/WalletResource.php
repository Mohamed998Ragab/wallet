<?php

namespace Modules\Wallet\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'balance' => number_format($this->balance, 2),
            'held_balance' => number_format($this->held_balance, 2),
            'available_balance' => $this->balance - $this->held_balance,
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
