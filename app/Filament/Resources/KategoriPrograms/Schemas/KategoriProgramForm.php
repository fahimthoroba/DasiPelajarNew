<?php

namespace App\Filament\Resources\KategoriPrograms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class KategoriProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_kategori')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->disabled()
                    ->dehydrated()
                    ->unique(ignoreRecord: true),

                Select::make('departemen_id')
                    ->relationship('departemen', 'nama_departemen')
                    ->required()
                    ->searchable()
                    ->preload(),

                // Admin PC dianggap auto-verify (true)
                Toggle::make('status_verifikasi')
                    ->label('Status Terverifikasi (Tampil di Semua PAC)')
                    ->default(true)
                    ->required(),
            ]);
    }
}
