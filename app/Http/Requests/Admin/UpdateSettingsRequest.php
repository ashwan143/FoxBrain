<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check()
            && auth()->user()->hasPermission('settings.edit');
    }

    public function rules(): array
    {
        return [
            'site_name' => [
                'required',
                'string',
                'max:255',
            ],

            'company_name' => [
                'required',
                'string',
                'max:255',
            ],

            'site_email' => [
                'nullable',
                'email',
                'max:191',
            ],

            'site_phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'currency' => [
                'required',
                'string',
                'max:10',
            ],

            'timezone' => [
                'required',
                'string',
                'max:100',
            ],

            'date_format' => [
                'required',
                'string',
                'max:30',
            ],
        ];
    }
}