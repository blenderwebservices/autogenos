<?php

namespace App\Filament\Resources\ErrorCodeLibraryResource\Pages;

use App\Filament\Resources\ErrorCodeLibraryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditErrorCodeLibrary extends EditRecord
{
    protected static string $resource = ErrorCodeLibraryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
