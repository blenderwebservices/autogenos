<?php

namespace App\Filament\Resources\EquipmentBrandResource\Pages;

use App\Filament\Resources\EquipmentBrandResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEquipmentBrand extends EditRecord
{
    protected static string $resource = EquipmentBrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
