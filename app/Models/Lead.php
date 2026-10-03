<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_code',
        'school_name',
        'contact_person',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'pincode',
        'lead_source_id',
        'school_type',
        'estimated_student_strength',
        'required_program_id',
        'assigned_sales_employee_id',
        'status',
        'priority',
        'remarks',
        'next_followup_at',
        'converted_school_id',
        'created_by',
    ];

    protected $casts = [
        'estimated_student_strength' => 'integer',
        'next_followup_at' => 'datetime',
    ];

    public function leadSource(): BelongsTo
    {
        return $this->belongsTo(
            LeadSource::class,
            'lead_source_id'
        );
    }

    public function requiredProgram(): BelongsTo
    {
        return $this->belongsTo(
            Program::class,
            'required_program_id'
        );
    }

    public function assignedSalesEmployee(): BelongsTo
    {
        return $this->belongsTo(
            SalesEmployee::class,
            'assigned_sales_employee_id'
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function convertedSchool(): BelongsTo
    {
        return $this->belongsTo(
            School::class,
            'converted_school_id'
        );
    }

    public function activities(): HasMany
    {
        return $this->hasMany(
            LeadActivity::class,
            'lead_id'
        );
    }

    public function followups(): HasMany
    {
        return $this->hasMany(
            LeadFollowup::class,
            'lead_id'
        );
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(
            Proposal::class,
            'lead_id'
        );
    }
}