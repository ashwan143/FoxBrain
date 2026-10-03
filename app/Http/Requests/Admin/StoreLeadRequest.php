<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check()
            && auth()->user()->hasPermission('leads.create');
    }

    public function rules(): array
    {
        return [
            'lead_code' => [
                'required',
                'string',
                'max:50',
                'unique:leads,lead_code',
            ],

            'school_name' => [
                'required',
                'string',
                'max:200',
            ],

            'contact_person' => [
                'nullable',
                'string',
                'max:200',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'email',
                'max:191',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'city' => [
                'nullable',
                'string',
                'max:100',
            ],

            'state' => [
                'nullable',
                'string',
                'max:100',
            ],

            'pincode' => [
                'nullable',
                'string',
                'max:20',
            ],

            'lead_source_id' => [
                'nullable',
                'integer',
                'exists:lead_sources,id',
            ],

            'school_type' => [
                'nullable',
                'string',
                'max:100',
            ],

            'estimated_student_strength' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'required_program_id' => [
                'nullable',
                'integer',
                'exists:programs,id',
            ],

            'assigned_sales_employee_id' => [
                'nullable',
                'integer',
                'exists:sales_employees,id',
            ],

            'status' => [
                'required',
                Rule::in([
                    'new',
                    'contacted',
                    'qualified',
                    'requirement_collected',
                    'proposal_sent',
                    'negotiation',
                    'won',
                    'lost',
                    'on_hold',
                    'not_interested',
                    'future_opportunity',
                ]),
            ],

            'priority' => [
                'required',
                Rule::in([
                    'low',
                    'medium',
                    'high',
                    'urgent',
                ]),
            ],

            'remarks' => [
                'nullable',
                'string',
            ],

            'next_followup_at' => [
                'nullable',
                'date',
            ],
        ];
    }
}