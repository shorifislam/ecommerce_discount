<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreDiscountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|unique:discounts',
            'discount_type' => 'required|string|in:percentage,money', // valid discount types
            'amount' => 'required|numeric|min:0.01', // greater than zero
            'min_cart_total' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'active_from' => 'nullable|date',
            'active_to' => 'nullable|date|after_or_equal:active_from',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'A discount code is required.',
            'code.string' => 'The discount code must be a valid text string.',
            'code.unique' => 'This discount code already exists. Please choose another.',

            'discount_type.required' => 'Discount type is required.',
            'discount_type.string' => 'The discount type must be a valid text string.',
            'discount_type.in' => 'The discount type must be either "percentage" or "money".',

            'amount.required' => 'The discount amount is required.',
            'amount.numeric' => 'The discount amount must be a valid number.',
            'amount.min' => 'The discount amount must be at least 0.',

            'min_cart_total.numeric' => 'The minimum cart total must be a valid number.',
            'min_cart_total.min' => 'The minimum cart total must be at least 0.',

            'is_active.boolean' => 'The "is active" field must be true or false.',

            'active_from.date' => 'The "active from" date must be a valid date format.',
            'active_to.date' => 'The "active to" date must be a valid date format.',
            'active_to.after_or_equal' => 'The "active to" date must be after or equal to the "active from" date.',
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
