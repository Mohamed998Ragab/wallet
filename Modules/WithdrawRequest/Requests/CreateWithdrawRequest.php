<?php

namespace Modules\WithdrawRequest\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWithdrawRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0.01'],
            'rejection_reason' => ['nullable', 'string', 'max:255'],
        ];
    }
}