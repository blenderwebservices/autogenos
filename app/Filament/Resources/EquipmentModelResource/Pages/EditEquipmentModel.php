<?php

namespace App\Filament\Resources\EquipmentModelResource\Pages;

use App\Filament\Resources\EquipmentModelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEquipmentModel extends EditRecord
{
    protected static string $resource = EquipmentModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
