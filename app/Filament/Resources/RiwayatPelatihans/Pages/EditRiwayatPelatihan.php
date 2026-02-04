<?php

namespace App\Filament\Resources\RiwayatPelatihans\Pages;

use App\Filament\Resources\RiwayatPelatihans\RiwayatPelatihanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatPelatihan extends EditRecord
{
    protected static string $resource = RiwayatPelatihanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
