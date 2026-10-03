<?php

namespace App\Services\Admin;

use App\Models\Lead;
use App\Models\LeadActivity;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class LeadActivityService
{
    public function paginate(
        Lead $lead,
        int $perPage = 15
    ): LengthAwarePaginator {
        return $lead->activities()
            ->with([
                'salesEmployee.user',
                'user',
            ])
            ->latest('activity_at')
            ->paginate($perPage);
    }

    public function getForLead(
        Lead $lead
    ): Collection {
        return $lead->activities()
            ->with([
                'salesEmployee.user',
                'user',
            ])
            ->latest('activity_at')
            ->get();
    }

    public function create(
        Lead $lead,
        array $data
    ): LeadActivity {
        return DB::transaction(function () use ($lead, $data) {

            $data['lead_id'] = $lead->id;
            $data['user_id'] = auth()->id();

            $activity = LeadActivity::create($data);

            ActivityLogServiceHelper::log(
                action: 'created',
                module: 'lead_activities',
                description: 'Lead activity created.',
                subject: $activity,
                newValues: $activity->fresh()->toArray()
            );

            return $activity;
        });
    }

    public function update(
        LeadActivity $activity,
        array $data
    ): LeadActivity {
        return DB::transaction(function () use ($activity, $data) {

            $oldValues = $activity->toArray();

            $activity->update($data);

            $activity->refresh();

            ActivityLogServiceHelper::log(
                action: 'updated',
                module: 'lead_activities',
                description: 'Lead activity updated.',
                subject: $activity,
                oldValues: $oldValues,
                newValues: $activity->toArray()
            );

            return $activity;
        });
    }

    public function delete(
        LeadActivity $activity
    ): void {
        DB::transaction(function () use ($activity) {

            $oldValues = $activity->toArray();

            ActivityLogServiceHelper::log(
                action: 'deleted',
                module: 'lead_activities',
                description: 'Lead activity deleted.',
                subject: $activity,
                oldValues: $oldValues
            );

            $activity->delete();
        });
    }
}