<?php

namespace App\Services\Admin;

use App\Models\ActivityLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ActivityLogService
{
    public function paginate(
        int $perPage = 20,
        ?string $module = null,
        ?string $action = null,
        ?string $search = null
    ): LengthAwarePaginator {
        return ActivityLog::with('user')
            ->when($module, function ($query) use ($module) {
                $query->where('module', $module);
            })
            ->when($action, function ($query) use ($action) {
                $query->where('action', $action);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('description', 'like', "%{$search}%")
                        ->orWhere('ip_address', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->latest('created_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function modules(): array
    {
        return ActivityLog::query()
            ->whereNotNull('module')
            ->distinct()
            ->orderBy('module')
            ->pluck('module')
            ->toArray();
    }

    public function actions(): array
    {
        return ActivityLog::query()
            ->whereNotNull('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action')
            ->toArray();
    }
}