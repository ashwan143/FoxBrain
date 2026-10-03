<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadSourceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check()
            && auth()->user()->hasPermission('lead_sources.edit');
    }

    public function rules(): array
    {
        $leadSource = $this->route('lead_source');

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('lead_sources', 'name')
                    ->ignore($leadSource?->id),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }
}