<?php

namespace App\Filament\Resources\Kaders\Pages;

use App\Filament\Resources\Kaders\KaderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKaders extends ListRecords
{
    protected static string $resource = KaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
