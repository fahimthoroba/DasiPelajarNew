<?php

namespace App\Filament\Resources\PengaturanWebs\Pages;

use App\Filament\Resources\PengaturanWebs\PengaturanWebResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPengaturanWeb extends EditRecord
{
    protected static string $resource = PengaturanWebResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
