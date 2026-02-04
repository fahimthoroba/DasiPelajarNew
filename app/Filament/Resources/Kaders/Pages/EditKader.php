<?php

namespace App\Filament\Resources\Kaders\Pages;

use App\Filament\Resources\Kaders\KaderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKader extends EditRecord
{
    protected static string $resource = KaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
