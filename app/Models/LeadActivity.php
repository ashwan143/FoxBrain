<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'sales_employee_id',
        'user_id',
        'activity_type',
        'subject',
        'activity_at',
        'notes',
        'outcome',
    ];

    protected $casts = [
        'activity_at' => 'datetime',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}