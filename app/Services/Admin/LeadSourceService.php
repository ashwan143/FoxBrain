<?php

namespace App\Services\Admin;

use App\Models\LeadSource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LeadSourceService
{
    public function paginate(
        int $perPage = 15,
        ?string $search = null,
        ?string $status = null
    ): LengthAwarePaginator {
        return LeadSource::query()
            ->withCount('leads')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere(
                            'description',
                            'like',
                            "%{$search}%"
                        );
                });
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where(
                    'is_active',
                    $status === 'active'
                );
            })
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): LeadSource
    {
        return DB::transaction(function () use ($data) {
            $leadSource = LeadSource::create($data);

            ActivityLogServiceHelper::log(
                action: 'created',
                module: 'lead_sources',
                description: "Lead source {$leadSource->name} was created.",
                subject: $leadSource,
                newValues: $leadSource->toArray()
            );

            return $leadSource;
        });
    }

    public function update(
        LeadSource $leadSource,
        array $data
    ): LeadSource {
        return DB::transaction(function () use (
            $leadSource,
            $data
        ) {
            $oldValues = $leadSource->toArray();

            $leadSource->update($data);

            ActivityLogServiceHelper::log(
                action: 'updated',
                module: 'lead_sources',
                description: "Lead source {$leadSource->name} was updated.",
                subject: $leadSource,
                oldValues: $oldValues,
                newValues: $leadSource->fresh()->toArray()
            );

            return $leadSource->fresh();
        });
    }

    public function delete(LeadSource $leadSource): void
    {
        if ($leadSource->leads()->exists()) {
            throw ValidationException::withMessages([
                'lead_source' =>
                    'This lead source is being used by leads and cannot be deleted. Deactivate it instead.',
            ]);
        }

        DB::transaction(function () use ($leadSource) {
            $oldValues = $leadSource->toArray();
            $name = $leadSource->name;

            $leadSource->delete();

            ActivityLogServiceHelper::log(
                action: 'deleted',
                module: 'lead_sources',
                description: "Lead source {$name} was deleted.",
                subjectType: LeadSource::class,
                subjectId: $leadSource->id,
                oldValues: $oldValues
            );
        });
    }
}