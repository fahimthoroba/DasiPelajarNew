<?php

namespace App\Filament\Resources\SuratKeputusans\Pages;

use App\Filament\Resources\SuratKeputusans\SuratKeputusanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSuratKeputusans extends ListRecords
{
    protected static string $resource = SuratKeputusanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
