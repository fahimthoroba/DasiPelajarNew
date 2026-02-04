<?php

namespace App\Filament\Resources\Kaders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KaderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nik'),
                // ->numeric()
                // ->minLength(16)
                // ->maxLength(16)
                // ->default('090909090909'),
                TextInput::make('nama_lengkap')
                    ->required(),
                \Filament\Forms\Components\FileUpload::make('foto_path')
                    ->image()
                    ->disk('public')
                    ->directory('kaders')
                    ->nullable(),
                TextInput::make('tempat_lahir'),
                // ->nullable()
                // ->default('Kediri'),
                DatePicker::make('tgl_lahir')
                    ->default(01 / 01 / 2000),
                \Filament\Forms\Components\Select::make('jenis_kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->required(),
                TextInput::make('alamat_jalan'),
                TextInput::make('dusun'),
                TextInput::make('desa'),
                TextInput::make('kecamatan'),
                TextInput::make('kabupaten')
                    ->default('Kediri'),
                TextInput::make('no_hp')
                    ->tel()
                    ->nullable(),
                \Filament\Forms\Components\Textarea::make('quote')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
