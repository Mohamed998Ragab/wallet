<?php

namespace Modules\WithdrawRequest\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RejectWithdrawRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check() && 
               auth('admin')->user()->hasPermission('accept_withdrawals');
    }

    public function rules(): array
    {
        return [
            'rejection_reason' => ['required', 'string', 'max:255'],
        ];
    }
}