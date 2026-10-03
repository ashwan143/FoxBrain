<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSalesEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check()
            && auth()->user()->hasPermission('sales_employees.edit');
    }

    public function rules(): array
    {
        $salesEmployee = $this->route('sales_employee');

        return [
            'user_id' => [
                'nullable',
                'integer',
                'exists:users,id',
                Rule::unique('sales_employees', 'user_id')
                    ->ignore($salesEmployee?->id),
            ],

            'employee_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('sales_employees', 'employee_code')
                    ->ignore($salesEmployee?->id),
            ],

            'manager_id' => [
                'nullable',
                'integer',
                'exists:sales_employees,id',
                function ($attribute, $value, $fail) use ($salesEmployee) {
                    if (
                        $salesEmployee &&
                        $value &&
                        (int) $value === (int) $salesEmployee->id
                    ) {
                        $fail('A sales employee cannot be their own manager.');
                    }
                },
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