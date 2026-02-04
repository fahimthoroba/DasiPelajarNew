<?php

namespace App\Filament\Resources\SuratKeputusans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SuratKeputusanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nomor_sk')
                    ->required(),
                TextInput::make('judul_sk')
                    ->required(),
                DatePicker::make('tgl_berlaku')
                    ->required(),
                DatePicker::make('tgl_selesai')
                    ->required(),
                TextInput::make('file_sk_path'),
            ]);
    }
}
