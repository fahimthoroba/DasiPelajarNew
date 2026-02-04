<?php

namespace App\Filament\Resources\SuratKeputusans\Pages;

use App\Filament\Resources\SuratKeputusans\SuratKeputusanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSuratKeputusan extends EditRecord
{
    protected static string $resource = SuratKeputusanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
