<?php

namespace App\Filament\Resources\RealisasiPrograms\Pages;

use App\Filament\Resources\RealisasiPrograms\RealisasiProgramResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRealisasiProgram extends EditRecord
{
    protected static string $resource = RealisasiProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
