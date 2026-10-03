<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSalesEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check()
            && auth()->user()->hasPermission('sales_employees.create');
    }

    public function rules(): array
    {
        return [
            'user_id' => [
                'nullable',
                'integer',
                'exists:users,id',
                'unique:sales_employees,user_id',
            ],

            'employee_code' => [
                'required',
                'string',
                'max:50',
                'unique:sales_employees,employee_code',
            ],

            'manager_id' => [
                'nullable',
                'integer',
                'exists:sales_employees,id',
            ],

            'designation' => [
                'nullable',
                'string',
                'max:100',
            ],

            'joining_date' => [
                'nullable',
                'date',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                    'on_leave',
                ]),
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ];
    }
}