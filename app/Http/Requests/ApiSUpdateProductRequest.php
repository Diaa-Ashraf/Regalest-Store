<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiSUpdateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ar.name' =>'required',
            'en.name' =>'required',
            'ar.description' =>'required',
            'en.description' =>'required',
            'price' =>'required',
            'quantity' =>'required',
            'category_id' =>'required|exists:categories,id',
             'image' =>'nullable|image|mimes:jpeg,png,jpg,gif,svg',
             'slug' =>'required'

        ];
    }
}
