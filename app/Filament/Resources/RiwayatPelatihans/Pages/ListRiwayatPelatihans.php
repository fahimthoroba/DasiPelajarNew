<?php

namespace App\Filament\Resources\RiwayatPelatihans\Pages;

use App\Filament\Resources\RiwayatPelatihans\RiwayatPelatihanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatPelatihans extends ListRecords
{
    protected static string $resource = RiwayatPelatihanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
