<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SparePart extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'compatible_models' => 'array',
            'supplier_info' => 'array',
            'price' => 'decimal:2',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function interventionParts(): HasMany
    {
        return $this->hasMany(InterventionPart::class, 'part_id');
    }

    public function interventions(): BelongsToMany
    {
        return $this->belongsToMany(Intervention::class, 'intervention_parts', 'part_id', 'intervention_id')
                    ->withPivot(['quantity', 'unit_price', 'discount_percent', 'observations'])
                    ->withTimestamps();
    }
}
