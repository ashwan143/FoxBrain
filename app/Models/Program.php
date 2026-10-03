<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'duration_months',
        'default_fee',
        'status',
    ];

    protected $casts = [
        'duration_months' => 'integer',
        'default_fee' => 'decimal:2',
    ];

    public function schoolPrograms()
    {
        return $this->hasMany(SchoolProgram::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'required_program_id');
    }
}