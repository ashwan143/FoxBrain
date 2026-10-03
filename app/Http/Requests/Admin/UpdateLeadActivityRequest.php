<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check()
            && auth()->user()->hasPermission('leads.edit');
    }

    public function rules(): array
    {
        return [
            'sales_employee_id' => [
                'nullable',
                'integer',
                'exists:sales_employees,id',
            ],

            'activity_type' => [
                'required',
                Rule::in([
                    'call',
                    'school_visit',
                    'meeting',
                    'email',
                    'whatsapp',
                    'note',
                    'other',
                ]),
            ],

            'subject' => [
                'required',
                'string',
                'max:255',
            ],

            'activity_at' => [
                'required',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'outcome' => [
                'nullable',
                'string',
            ],
        ];
    }
}