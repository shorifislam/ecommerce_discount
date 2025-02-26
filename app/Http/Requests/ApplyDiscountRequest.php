<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApplyDiscountRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|exists:discounts',
            'subtotal' => 'required|numeric|min:0.01',
        ];
    }


    public function messages()
    {
        return [
            'code.exists' => 'The discount code entered does not exist or is invalid.',
            'subtotal.required' => 'Subtotal is required to apply the discount.',
            'subtotal.numeric' => 'Subtotal must be a valid number.',
            'subtotal.min' => 'Subtotal must be at least 0.01.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422));
    }
}
