<?php

namespace App\Filament\Resources\RealisasiPrograms\Pages;

use App\Filament\Resources\RealisasiPrograms\RealisasiProgramResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRealisasiPrograms extends ListRecords
{
    protected static string $resource = RealisasiProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Kegiatan')
                ->slideOver()
                ->using(function (array $data, string $model): \Illuminate\Database\Eloquent\Model {
                    return $model::create($data);
                }),
        ];
    }
}
