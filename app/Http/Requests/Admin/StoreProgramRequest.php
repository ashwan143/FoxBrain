<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check()
            && auth()->user()->hasPermission('programs.create');
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'code' => [
                'nullable',
                'string',
                'max:50',
                'unique:programs,code',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'duration_months' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'default_fee' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999.99',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ];
    }
}