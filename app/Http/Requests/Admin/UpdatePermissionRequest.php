<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check()
            && auth()->user()->hasPermission('permissions.manage');
    }

    public function rules(): array
    {
        $permission = $this->route('permission');

        return [
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'slug' => [
    'required',
    'string',
    'max:150',
    'regex:/^[a-z0-9._-]+$/',
    'unique:permissions,slug',
],

            'module' => [
                'required',
                'string',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ];
    }
}