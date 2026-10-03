<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadFollowupRequest extends FormRequest
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

            'scheduled_at' => [
                'required',
                'date',
            ],

            'status' => [
                'required',
                Rule::in([
                    'scheduled',
                    'completed',
                    'cancelled',
                    'missed',
                ]),
            ],

            'followup_type' => [
                'required',
                Rule::in([
                    'call',
                    'visit',
                    'meeting',
                    'email',
                    'whatsapp',
                    'other',
                ]),
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'outcome' => [
                'nullable',
                'string',
            ],

            'completed_at' => [
                'nullable',
                'date',
                'required_if:status,completed',
            ],
        ];
    }
}
