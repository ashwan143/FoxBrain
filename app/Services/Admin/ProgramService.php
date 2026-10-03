<?php

namespace App\Services\Admin;

use App\Models\ActivityLog;
use App\Models\Program;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProgramService
{
    public function paginate(
        int $perPage = 15,
        ?string $search = null,
        ?string $status = null
    ): LengthAwarePaginator {
        return Program::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): Program
    {
        return DB::transaction(function () use ($data) {
            $program = Program::create($data);

            $this->log(
                action: 'created',
                description: "Program '{$program->name}' was created.",
                program: $program
            );

            return $program;
        });
    }

    public function update(Program $program, array $data): Program
    {
        return DB::transaction(function () use ($program, $data) {
            $oldValues = $program->getAttributes();

            $program->update($data);

            $this->log(
                action: 'updated',
                description: "Program '{$program->name}' was updated.",
                program: $program,
                oldValues: $oldValues,
                newValues: $program->getAttributes()
            );

            return $program->refresh();
        });
    }

    public function delete(Program $program): void
    {
        DB::transaction(function () use ($program) {
            $programName = $program->name;
            $programId = $program->id;

            $program->delete();

            $this->log(
                action: 'deleted',
                description: "Program '{$programName}' was deleted.",
                programId: $programId
            );
        });
    }

    private function log(
        string $action,
        string $description,
        ?Program $program = null,
        ?int $programId = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): void {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'module' => 'programs',
            'description' => $description,
            'subject_type' => Program::class,
            'subject_id' => $program?->id ?? $programId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}