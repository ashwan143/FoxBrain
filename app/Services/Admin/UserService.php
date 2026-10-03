<?php

namespace App\Services\Admin;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return User::with('role')
            ->latest('id')
            ->paginate($perPage);
    }

    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {

            $user = User::create($data);

            $this->log(
                action: 'created',
                description: "User {$user->name} was created.",
                user: $user
            );

            return $user;
        });
    }

    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {

            $oldValues = $user->only([
                'role_id',
                'name',
                'email',
                'phone',
                'status',
            ]);

            /*
             * Don't overwrite the existing password
             * when the password field is empty.
             */
            if (empty($data['password'])) {
                unset($data['password']);
            }

            $user->update($data);

            $newValues = $user->fresh()->only([
                'role_id',
                'name',
                'email',
                'phone',
                'status',
            ]);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'updated',
                'module' => 'users',
                'description' => "User {$user->name} was updated.",
                'subject_type' => User::class,
                'subject_id' => $user->id,
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return $user->fresh();
        });
    }

    public function delete(User $user): void
    {
        DB::transaction(function () use ($user) {

            /*
             * Never allow the currently logged-in user
             * to delete their own account.
             */
            if ($user->id === auth()->id()) {
                throw new \RuntimeException(
                    'You cannot delete your own account.'
                );
            }

            /*
             * Prevent deletion of the Super Admin account.
             */
            if ($user->isSuperAdmin()) {
                throw new \RuntimeException(
                    'The Super Admin account cannot be deleted.'
                );
            }

            $name = $user->name;
            $id = $user->id;

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted',
                'module' => 'users',
                'description' => "User {$name} was deleted.",
                'subject_type' => User::class,
                'subject_id' => $id,
                'old_values' => $user->only([
                    'role_id',
                    'name',
                    'email',
                    'phone',
                    'status',
                ]),
                'new_values' => null,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            $user->delete();
        });
    }

    private function log(
        string $action,
        string $description,
        User $user
    ): void {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'module' => 'users',
            'description' => $description,
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'old_values' => null,
            'new_values' => $user->only([
                'role_id',
                'name',
                'email',
                'phone',
                'status',
            ]),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}