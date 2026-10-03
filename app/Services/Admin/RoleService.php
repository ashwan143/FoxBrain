<?php

namespace App\Services\Admin;

use App\Models\ActivityLog;
use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class RoleService
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Role::withCount('users')
            ->withCount('permissions')
            ->latest('id')
            ->paginate($perPage);
    }

    public function create(array $data): Role
    {
        return DB::transaction(function () use ($data) {

            $permissions = $data['permissions'] ?? [];

            unset($data['permissions']);

            $role = Role::create($data);

            $role->permissions()->sync($permissions);

            $this->log(
                action: 'created',
                description: "Role {$role->name} was created.",
                role: $role
            );

            return $role->load('permissions');
        });
    }

    public function update(Role $role, array $data): Role
    {
        return DB::transaction(function () use ($role, $data) {

            $permissions = $data['permissions'] ?? [];

            unset($data['permissions']);

            $oldValues = [
                'name' => $role->name,
                'slug' => $role->slug,
                'description' => $role->description,
                'is_active' => $role->is_active,
            ];

            $role->update($data);

            $role->permissions()->sync($permissions);

            $newRole = $role->fresh();

            $this->log(
                action: 'updated',
                description: "Role {$role->name} was updated.",
                role: $newRole,
                oldValues: $oldValues,
                newValues: [
                    'name' => $newRole->name,
                    'slug' => $newRole->slug,
                    'description' => $newRole->description,
                    'is_active' => $newRole->is_active,
                ]
            );

            return $newRole->load('permissions');
        });
    }

    public function delete(Role $role): void
    {
        DB::transaction(function () use ($role) {

            if ($role->slug === 'super-admin') {
                throw new \RuntimeException(
                    'The Super Admin role cannot be deleted.'
                );
            }

            if ($role->users()->exists()) {
                throw new \RuntimeException(
                    'This role cannot be deleted because users are assigned to it.'
                );
            }

            $name = $role->name;
            $id = $role->id;

            $oldValues = [
                'name' => $role->name,
                'slug' => $role->slug,
                'description' => $role->description,
                'is_active' => $role->is_active,
            ];

            $role->permissions()->detach();

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted',
                'module' => 'roles',
                'description' => "Role {$name} was deleted.",
                'subject_type' => Role::class,
                'subject_id' => $id,
                'old_values' => $oldValues,
                'new_values' => null,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            $role->delete();
        });
    }

    private function log(
        string $action,
        string $description,
        Role $role,
        ?array $oldValues = null,
        ?array $newValues = null
    ): void {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'module' => 'roles',
            'description' => $description,
            'subject_type' => Role::class,
            'subject_id' => $role->id,
            'old_values' => $oldValues,
            'new_values' => $newValues ?? [
                'name' => $role->name,
                'slug' => $role->slug,
                'description' => $role->description,
                'is_active' => $role->is_active,
            ],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}