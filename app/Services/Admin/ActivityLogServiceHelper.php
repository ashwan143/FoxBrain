<?php

namespace App\Services\Admin;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class ActivityLogServiceHelper
{
    public static function log(
        string $action,
        ?string $module = null,
        ?string $description = null,
        ?Model $subject = null,
        ?string $subjectType = null,
        ?int $subjectId = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): ActivityLog {
        if ($subject) {
            $subjectType = $subject::class;
            $subjectId = $subject->getKey();
        }

        return ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}