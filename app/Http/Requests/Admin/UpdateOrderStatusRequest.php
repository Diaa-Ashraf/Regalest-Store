<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Order;
use Illuminate\Validation\Rule;

class UpdateOrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => [
                'required',
                'string',
                Rule::in([
                    Order::STATUS_PENDING,
                    Order::STATUS_CONFIRMED,
                    Order::STATUS_PROCESSING,
                    Order::STATUS_SHIPPED,
                    Order::STATUS_DELIVERED,
                    Order::STATUS_CANCELLED,
                ]),
            ],
            'cancel_reason' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'حالة الطلب مطلوبة.',
            'status.in' => 'حالة الطلب المختارة غير صالحة.',
            'cancel_reason.required_if' => 'يرجى تدوين سبب إلغاء الطلب.',
            'cancel_reason.max' => 'سبب الإلغاء يجب ألا يتجاوز 500 حرف.',
        ];
    }
}
