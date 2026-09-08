<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'settings' => 'required|array',
            'settings.*' => 'nullable',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'site_favicon' => 'nullable|mimes:jpeg,png,jpg,webp,svg,ico|max:1024',
        ];
    }

    public function messages(): array
    {
        return [
            'settings.required' => 'بيانات الإعدادات مطلوبة.',
            'site_logo.image' => 'شعار الموقع يجب أن يكون ملف صورة صالح.',
            'site_logo.mimes' => 'صيغ الشعار المدعومة هي: png, jpg, jpeg, webp, svg.',
            'site_logo.max' => 'حجم الشعار يجب ألا يتجاوز 2 ميغابايت.',
            'site_favicon.mimes' => 'صيغ أيقونة التاب (Favicon) المدعومة هي: ico, png, jpg, webp, svg.',
            'site_favicon.max' => 'حجم أيقونة التاب يجب ألا يتجاوز 1 ميغابايت.',
        ];
    }
}
