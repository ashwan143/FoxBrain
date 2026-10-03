<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() &&
            auth()->user()->hasPermission('users.create');
    }

    public function rules(): array
    {
        return [
            'role_id' => [
                'nullable',
                'integer',
                Rule::exists('roles', 'id')->where('is_active', true),
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:191',
                'unique:users,email',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'status' => [
                'required',
                Rule::in(['active', 'inactive', 'suspended']),
            ],
        ];
    }
}