<?php

namespace App\Filament\Resources\ErrorCodeLibraryResource\Pages;

use App\Filament\Resources\ErrorCodeLibraryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListErrorCodeLibraries extends ListRecords
{
    protected static string $resource = ErrorCodeLibraryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
