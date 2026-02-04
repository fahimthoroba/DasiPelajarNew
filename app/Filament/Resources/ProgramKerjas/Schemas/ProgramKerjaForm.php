<?php

namespace App\Filament\Resources\ProgramKerjas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProgramKerjaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_proker')
                    ->required(),
                DatePicker::make('tgl_pelaksanaan')
                    ->required(),
                TextInput::make('penanggung_jawab')
                    ->required(),
                TextInput::make('path_lpj'),
                TextInput::make('status_lpj')
                    ->required()
                    ->default('Belum'),
            ]);
    }
}
