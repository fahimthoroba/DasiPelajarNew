<?php

namespace App\Filament\Resources\RiwayatPelatihans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RiwayatPelatihanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kader_id')
                    ->required()
                    ->numeric(),
                TextInput::make('nama_pelatihan')
                    ->required(),
                TextInput::make('jenis')
                    ->required(),
                TextInput::make('penyelenggara')
                    ->required(),
                TextInput::make('tahun')
                    ->required()
                    ->numeric(),
                TextInput::make('lokasi'),
                TextInput::make('nomor_sertifikat'),
            ]);
    }
}
