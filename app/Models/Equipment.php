<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'installation_date' => 'date',
            'last_maintenance_date' => 'date',
            'next_maintenance_date' => 'date',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'rated_power_kw' => 'decimal:2',
            'total_operating_hours' => 'decimal:2',
            'metadata' => 'array',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(EquipmentBrand::class, 'brand_id');
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(EquipmentModel::class, 'model_id');
    }

    public function interventions(): HasMany
    {
        return $this->hasMany(Intervention::class)->latest('start_date');
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }
}
