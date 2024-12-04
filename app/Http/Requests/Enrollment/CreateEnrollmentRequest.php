<?php

namespace App\Http\Requests\Enrollment;

use Illuminate\Foundation\Http\FormRequest;

class CreateEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Add proper authorization logic
    }

    public function rules(): array
    {
        return [
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:credit_card,paypal,bank_transfer',
            'payment_status' => 'required|string|in:pending,completed,failed',
            'expires_at' => 'nullable|date|after:now',
        ];
    }

    public function messages(): array
    {
        return [
            'paid_amount.required' => 'The payment amount is required',
            'paid_amount.min' => 'The payment amount must be at least 0',
            'payment_method.in' => 'Invalid payment method selected',
            'payment_status.in' => 'Invalid payment status',
            'expires_at.after' => 'The expiry date must be in the future',
        ];
    }
} 