<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() &&
            auth()->user()->hasPermission('users.edit');
    }

    public function rules(): array
    {
        $user = $this->route('user');

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
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'password' => [
                'nullable',
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