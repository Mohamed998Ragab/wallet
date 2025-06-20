<?php

namespace Modules\TopUpRequest\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RejectTopUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check() && 
               auth('admin')->user()->hasPermission('accept_topup');
    }

    public function rules(): array
    {
        return [
            'rejection_reason' => ['required', 'string', 'max:255'],
        ];
    }
}