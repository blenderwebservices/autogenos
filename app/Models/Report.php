<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'report_data' => 'array',
            'generated_at' => 'datetime',
            'sent_at' => 'datetime',
            'technician_signed' => 'boolean',
            'client_signed' => 'boolean',
        ];
    }

    public function intervention(): BelongsTo
    {
        return $this->belongsTo(Intervention::class);
    }
}
