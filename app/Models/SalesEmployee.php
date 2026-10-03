<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesEmployee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_code',
        'manager_id',
        'designation',
        'joining_date',
        'phone',
        'status',
        'notes',
    ];

    protected $casts = [
        'joining_date' => 'date',
    ];

    /**
     * Login/user account.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Sales manager.
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(
            SalesEmployee::class,
            'manager_id'
        );
    }

    /**
     * Employees managed by this employee.
     */
    public function teamMembers(): HasMany
    {
        return $this->hasMany(
            SalesEmployee::class,
            'manager_id'
        );
    }

    /**
     * Leads assigned to this employee.
     */
    public function leads(): HasMany
    {
        return $this->hasMany(
            Lead::class,
            'assigned_sales_employee_id'
        );
    }

    /**
     * Lead activities performed by this employee.
     */
    public function leadActivities(): HasMany
    {
        return $this->hasMany(
            LeadActivity::class,
            'sales_employee_id'
        );
    }

    /**
     * Lead follow-ups assigned to this employee.
     */
    public function leadFollowups(): HasMany
    {
        return $this->hasMany(
            LeadFollowup::class,
            'sales_employee_id'
        );
    }
}