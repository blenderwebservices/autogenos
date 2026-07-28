<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Intervention extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'error_codes' => 'array',
            'ai_suggestions' => 'array',
            'ai_confidence' => 'decimal:2',
            'total_operating_hours' => 'decimal:2',
            'estimated_cost' => 'decimal:2',
            'actual_cost' => 'decimal:2',
            'start_date' => 'datetime',
            'completion_date' => 'datetime',
            'signed_at' => 'datetime',
            'location_lat' => 'decimal:8',
            'location_lng' => 'decimal:8',
            'metadata' => 'array',
        ];
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function checklists(): HasMany
    {
        return $this->hasMany(InspectionChecklist::class);
    }

    public function interventionParts(): HasMany
    {
        return $this->hasMany(InterventionPart::class);
    }

    public function spareParts(): BelongsToMany
    {
        return $this->belongsToMany(SparePart::class, 'intervention_parts')
                    ->withPivot(['quantity', 'unit_price', 'discount_percent', 'observations'])
                    ->withTimestamps();
    }

    public function report(): HasOne
    {
        return $this->hasOne(Report::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }
}
