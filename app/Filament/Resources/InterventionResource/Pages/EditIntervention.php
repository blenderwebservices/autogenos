<?php

namespace App\Filament\App\Resources\InterventionResource\Pages;

use App\Filament\App\Resources\InterventionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIntervention extends EditRecord
{
    protected static string $resource = InterventionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
