<?php

namespace Modules\Transaction\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'wallet_id' => $this->wallet_id,
            'amount' => number_format($this->amount, 2),
            'type' => $this->type,
            'request_id' => $this->request_id,
            'request_type' => $this->request_type,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
