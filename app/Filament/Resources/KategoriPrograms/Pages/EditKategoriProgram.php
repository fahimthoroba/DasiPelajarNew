<?php

namespace App\Filament\Resources\KategoriPrograms\Pages;

use App\Filament\Resources\KategoriPrograms\KategoriProgramResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKategoriProgram extends EditRecord
{
    protected static string $resource = KategoriProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
