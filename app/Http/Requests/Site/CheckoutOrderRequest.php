<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:150',
            'phone' => 'required|string|min:7|max:30',
            'address' => 'required|string|min:5|max:300',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'يرجى إدخال الاسم الكريم.',
            'name.min' => 'الاسم يجب أن يتكون من 3 أحرف على الأقل.',
            'phone.required' => 'يرجى إدخال رقم الهاتف للتواصل عبر واتساب.',
            'phone.min' => 'يرجى التأكد من صحة رقم الهاتف.',
            'address.required' => 'يرجى إدخال عنوان التوصيل بالتفصيل.',
            'address.min' => 'العنوان قصير جداً، يرجى كتابة تفاصيل المدينة والمنطقة.',
            'notes.max' => 'الملاحظات لا يجب أن تتجاوز 500 حرف.',
        ];
    }
}
