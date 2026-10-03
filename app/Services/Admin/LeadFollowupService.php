<?php

namespace App\Services\Admin;

use App\Models\Lead;
use App\Models\LeadFollowup;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class LeadFollowupService
{
    public function paginate(
        Lead $lead,
        int $perPage = 15
    ): LengthAwarePaginator {
        return $lead->followups()
            ->with([
                'salesEmployee.user',
                'createdBy',
            ])
            ->latest('scheduled_at')
            ->paginate($perPage);
    }

    public function getForLead(
        Lead $lead
    ): Collection {
        return $lead->followups()
            ->with([
                'salesEmployee.user',
                'createdBy',
            ])
            ->latest('scheduled_at')
            ->get();
    }

    public function create(
        Lead $lead,
        array $data
    ): LeadFollowup {
        return DB::transaction(function () use ($lead, $data) {

            $data['lead_id'] = $lead->id;
            $data['created_by'] = auth()->id();

            if (
                ($data['status'] ?? null) === 'completed'
                && empty($data['completed_at'])
            ) {
                $data['completed_at'] = now();
            }

            $followup = LeadFollowup::create($data);

            ActivityLogServiceHelper::log(
                action: 'created',
                module: 'lead_followups',
                description: 'Lead follow-up created.',
                subject: $followup,
                newValues: $followup->fresh()->toArray()
            );

            return $followup;
        });
    }

    public function update(
        LeadFollowup $followup,
        array $data
    ): LeadFollowup {
        return DB::transaction(function () use ($followup, $data) {

            $oldValues = $followup->toArray();

            if (
                ($data['status'] ?? null) === 'completed'
                && empty($data['completed_at'])
            ) {
                $data['completed_at'] = now();
            }

            if (
                ($data['status'] ?? null) !== 'completed'
            ) {
                $data['completed_at'] = null;
            }

            $followup->update($data);

            $followup->refresh();

            ActivityLogServiceHelper::log(
                action: 'updated',
                module: 'lead_followups',
                description: 'Lead follow-up updated.',
                subject: $followup,
                oldValues: $oldValues,
                newValues: $followup->toArray()
            );

            return $followup;
        });
    }

    public function delete(
        LeadFollowup $followup
    ): void {
        DB::transaction(function () use ($followup) {

            $oldValues = $followup->toArray();

            ActivityLogServiceHelper::log(
                action: 'deleted',
                module: 'lead_followups',
                description: 'Lead follow-up deleted.',
                subject: $followup,
                oldValues: $oldValues
            );

            $followup->delete();
        });
    }
}