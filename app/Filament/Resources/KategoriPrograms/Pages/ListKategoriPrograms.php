<?php

namespace App\Filament\Resources\KategoriPrograms\Pages;

use App\Filament\Resources\KategoriPrograms\KategoriProgramResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKategoriPrograms extends ListRecords
{
    protected static string $resource = KategoriProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
