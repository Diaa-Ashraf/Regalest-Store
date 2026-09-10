<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:500'],
            'preferred_currency' => ['nullable', 'string', 'in:USD,EUR,SAR,AED,EGP'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ];
    }

    /**
     * Custom Arabic validation messages
     */
    public function messages(): array
    {
        return [
            'name.required' => __('يرجى إدخال الاسم الكامل.'),
            'name.max' => __('يجب ألا يتجاوز الاسم 255 حرفاً.'),
            'email.required' => __('يرجى إدخال البريد الإلكتروني.'),
            'email.email' => __('صيغة البريد الإلكتروني غير صحيحة.'),
            'email.unique' => __('هذا البريد الإلكتروني مسجل بالفعل لمستخدم آخر.'),
            'phone.max' => __('رقم الهاتف يجب ألا يتجاوز 30 حرفاً.'),
            'address.max' => __('العنوان يجب ألا يتجاوز 500 حرف.'),
            'preferred_currency.in' => __('العملة المختارة غير مدعومة.'),
            'avatar.image' => __('يجب أن يكون الملف المرفوع صورة صالحة.'),
            'avatar.mimes' => __('صيغ الصور المدعومة هي: JPEG, PNG, JPG, WEBP.'),
            'avatar.max' => __('الحد الأقصى لحجم الصورة هو 3 ميجابايت.'),
        ];
    }
}
