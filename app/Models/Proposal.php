<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_number',
        'lead_id',
        'school_id',
        'title',
        'proposal_date',
        'valid_until',
        'subtotal',
        'discount',
        'tax',
        'total',
        'status',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'proposal_date' => 'date',
        'valid_until' => 'date',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(
            Lead::class,
            'lead_id'
        );
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(
            School::class,
            'school_id'
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }
}