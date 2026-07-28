<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipmentBrand extends Model
{
    protected $guarded = [];

    public function models(): HasMany
    {
        return $this->hasMany(EquipmentModel::class, 'brand_id');
    }

    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class, 'brand_id');
    }

    public function knowledgeBase(): HasMany
    {
        return $this->hasMany(KnowledgeBase::class, 'brand_id');
    }

    public function errorCodes(): HasMany
    {
        return $this->hasMany(ErrorCodeLibrary::class, 'brand_id');
    }
}
