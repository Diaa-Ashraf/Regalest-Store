<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Middleware\TrustProxies;

class ApiStoreCategoryRequest extends FormRequest
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
            'ar.name'=>'required',
            'en.name'=>'required',
            'ar.description'=>'required',
            'en.description'=>'required',
            'image'=>'required',
            'slug'=>'required'
        ];
    }
}
