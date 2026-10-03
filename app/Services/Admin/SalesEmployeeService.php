<?php

namespace App\Services\Admin;

use App\Models\SalesEmployee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SalesEmployeeService
{
    public function paginate(
        int $perPage = 15,
        ?string $search = null,
        ?string $status = null
    ): LengthAwarePaginator {
        return SalesEmployee::query()
            ->with([
                'user',
                'manager.user',
            ])
            ->withCount([
                'teamMembers',
                'leads',
            ])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where(
                            'employee_code',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'designation',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'phone',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query
                                ->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'email',
                                    'like',
                                    "%{$search}%"
                                );
                        });
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('employee_code')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): SalesEmployee
    {
        return DB::transaction(function () use ($data) {
            $salesEmployee = SalesEmployee::create($data);

            ActivityLogServiceHelper::log(
                action: 'created',
                module: 'sales_employees',
                description: "Sales employee {$salesEmployee->employee_code} was created.",
                subject: $salesEmployee,
                newValues: $salesEmployee->toArray()
            );

            return $salesEmployee;
        });
    }

    public function update(
        SalesEmployee $salesEmployee,
        array $data
    ): SalesEmployee {
        return DB::transaction(function () use (
            $salesEmployee,
            $data
        ) {
            $oldValues = $salesEmployee->toArray();

            $salesEmployee->update($data);

            ActivityLogServiceHelper::log(
                action: 'updated',
                module: 'sales_employees',
                description: "Sales employee {$salesEmployee->employee_code} was updated.",
                subject: $salesEmployee,
                oldValues: $oldValues,
                newValues: $salesEmployee->fresh()->toArray()
            );

            return $salesEmployee->fresh();
        });
    }

    public function delete(SalesEmployee $salesEmployee): void
    {
        if ($salesEmployee->teamMembers()->exists()) {
            throw ValidationException::withMessages([
                'sales_employee' =>
                    'This sales employee manages other employees. Reassign the team members before deleting.',
            ]);
        }

        if ($salesEmployee->leads()->exists()) {
            throw ValidationException::withMessages([
                'sales_employee' =>
                    'This sales employee has assigned leads. Reassign the leads before deleting.',
            ]);
        }

        DB::transaction(function () use ($salesEmployee) {
            $oldValues = $salesEmployee->toArray();

            $employeeCode = $salesEmployee->employee_code;

            $salesEmployee->delete();

            ActivityLogServiceHelper::log(
                action: 'deleted',
                module: 'sales_employees',
                description: "Sales employee {$employeeCode} was deleted.",
                subjectType: SalesEmployee::class,
                subjectId: $salesEmployee->id,
                oldValues: $oldValues
            );
        });
    }
}