<?php

namespace Modules\Transaction\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'wallet_id' => ['required', 'exists:wallets,id'],
            'amount' => ['required', 'numeric'],
            'type' => ['required', 'in:referral_bonus,withdrawal,top_up'],
        ];
    }
}