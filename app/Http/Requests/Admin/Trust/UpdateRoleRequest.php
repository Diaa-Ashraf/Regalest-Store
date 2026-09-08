<?php

namespace App\Http\Requests\Admin\Trust;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
            'name' => 'required|unique:roles,name,' . $this->role->id,
            'display_name' => 'required|unique:roles,display_name,' . $this->role->id,

            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,name',
        ];
    }
}
