<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadFollowup extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'sales_employee_id',
        'scheduled_at',
        'completed_at',
        'status',
        'followup_type',
        'notes',
        'outcome',
        'created_by',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function salesEmployee(): BelongsTo
    {
        return $this->belongsTo(
            SalesEmployee::class,
            'sales_employee_id'
        );
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }
}