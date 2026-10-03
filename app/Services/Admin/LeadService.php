<?php

namespace App\Services\Admin;

use App\Models\Lead;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class LeadService
{
    public function paginate(
        int $perPage = 15,
        ?string $search = null,
        ?string $status = null,
        ?string $priority = null,
        ?int $assignedSalesEmployeeId = null
    ): LengthAwarePaginator {
        return Lead::query()
            ->with([
                'leadSource',
                'requiredProgram',
                'assignedSalesEmployee',
                'creator',
            ])
            ->withCount([
                'activities',
                'followups',
                'proposals',
            ])
            ->when(
                $search,
                function (Builder $query) use ($search) {
                    $query->where(function (Builder $q) use ($search) {
                        $q->where(
                            'lead_code',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'school_name',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'contact_person',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'phone',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'email',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'city',
                            'like',
                            "%{$search}%"
                        );
                    });
                }
            )
            ->when(
                $status,
                fn (Builder $query) =>
                    $query->where('status', $status)
            )
            ->when(
                $priority,
                fn (Builder $query) =>
                    $query->where('priority', $priority)
            )
            ->when(
                $assignedSalesEmployeeId,
                fn (Builder $query) =>
                    $query->where(
                        'assigned_sales_employee_id',
                        $assignedSalesEmployeeId
                    )
            )
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): Lead
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id();

            $lead = Lead::create($data);

            ActivityLogServiceHelper::log(
                action: 'created',
                module: 'leads',
                description: "Lead {$lead->lead_code} created.",
                subject: $lead,
                newValues: $lead->fresh()->toArray()
            );

            return $lead;
        });
    }

    public function update(
        Lead $lead,
        array $data
    ): Lead {
        return DB::transaction(function () use ($lead, $data) {
            $oldValues = $lead->toArray();

            $lead->update($data);

            ActivityLogServiceHelper::log(
                action: 'updated',
                module: 'leads',
                description: "Lead {$lead->lead_code} updated.",
                subject: $lead,
                oldValues: $oldValues,
                newValues: $lead->fresh()->toArray()
            );

            return $lead->fresh();
        });
    }

    public function delete(Lead $lead): void
    {
        DB::transaction(function () use ($lead) {
            $oldValues = $lead->toArray();

            $leadCode = $lead->lead_code;

            $lead->delete();

            ActivityLogServiceHelper::log(
                action: 'deleted',
                module: 'leads',
                description: "Lead {$leadCode} deleted.",
                subjectType: Lead::class,
                subjectId: $lead->id,
                oldValues: $oldValues
            );
        });
    }

    public function statistics(): array
    {
        return [
            'total' => Lead::count(),

            'new' => Lead::where(
                'status',
                'new'
            )->count(),

            'qualified' => Lead::where(
                'status',
                'qualified'
            )->count(),

            'proposal_sent' => Lead::where(
                'status',
                'proposal_sent'
            )->count(),

            'negotiation' => Lead::where(
                'status',
                'negotiation'
            )->count(),

            'won' => Lead::where(
                'status',
                'won'
            )->count(),

            'lost' => Lead::where(
                'status',
                'lost'
            )->count(),

            'urgent' => Lead::where(
                'priority',
                'urgent'
            )->count(),
        ];
    }
}