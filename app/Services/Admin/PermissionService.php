<?php

namespace App\Services\Admin;

use App\Models\ActivityLog;
use App\Models\Permission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PermissionService
{
    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return Permission::withCount('roles')
            ->orderBy('module')
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function create(array $data): Permission
    {
        return DB::transaction(function () use ($data) {

            $permission = Permission::create($data);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'created',
                'module' => 'permissions',
                'description' => "Permission {$permission->name} was created.",
                'subject_type' => Permission::class,
                'subject_id' => $permission->id,
                'old_values' => null,
                'new_values' => $permission->only([
                    'name',
                    'slug',
                    'module',
                    'description',
                ]),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return $permission;
        });
    }

    public function update(
        Permission $permission,
        array $data
    ): Permission {
        return DB::transaction(function () use ($permission, $data) {

            $oldValues = $permission->only([
                'name',
                'slug',
                'module',
                'description',
            ]);

            $permission->update($data);

            $permission = $permission->fresh();

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'updated',
                'module' => 'permissions',
                'description' => "Permission {$permission->name} was updated.",
                'subject_type' => Permission::class,
                'subject_id' => $permission->id,
                'old_values' => $oldValues,
                'new_values' => $permission->only([
                    'name',
                    'slug',
                    'module',
                    'description',
                ]),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return $permission;
        });
    }

    public function delete(Permission $permission): void
    {
        DB::transaction(function () use ($permission) {

            if ($permission->roles()->exists()) {
                throw new \RuntimeException(
                    'This permission cannot be deleted because it is assigned to one or more roles.'
                );
            }

            $oldValues = $permission->only([
                'name',
                'slug',
                'module',
                'description',
            ]);

            $name = $permission->name;
            $id = $permission->id;

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted',
                'module' => 'permissions',
                'description' => "Permission {$name} was deleted.",
                'subject_type' => Permission::class,
                'subject_id' => $id,
                'old_values' => $oldValues,
                'new_values' => null,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            $permission->delete();
        });
    }
}