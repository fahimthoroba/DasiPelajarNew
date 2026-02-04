<?php

namespace App\Filament\Resources\PengaturanWebs\Pages;

use App\Filament\Resources\PengaturanWebs\PengaturanWebResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPengaturanWebs extends ListRecords
{
    protected static string $resource = PengaturanWebResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
