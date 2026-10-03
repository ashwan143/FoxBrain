<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check()
            && auth()->user()->hasPermission('programs.edit');
    }

    public function rules(): array
    {
        $program = $this->route('program');

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
                Rule::unique('programs', 'code')
                    ->ignore($program->id),
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