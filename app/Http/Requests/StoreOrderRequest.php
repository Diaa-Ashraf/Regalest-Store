<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'required|exists:users,id',
            'address' => 'required|string',
            'phone' => 'required|string',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:1',
            //'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,completed,cancelled',
            'payment_method' => 'required|in:cash,credit',
        ];
        
    }
}
