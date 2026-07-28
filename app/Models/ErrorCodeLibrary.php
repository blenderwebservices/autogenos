<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ErrorCodeLibrary extends Model
{
    protected $table = 'error_code_library';
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'possible_causes' => 'array',
            'recommended_actions' => 'array',
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(EquipmentBrand::class, 'brand_id');
    }
}
