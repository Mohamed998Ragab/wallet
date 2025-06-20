<?php

namespace Modules\TopUpRequest\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTopUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0.01'],
        ];
    }
}