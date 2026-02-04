<?php

namespace App\Filament\Resources\KategoriBeritas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KategoriBeritaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(string $operation, $state, $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                TextInput::make('slug')
                    ->required()
                    ->unique(\App\Models\KategoriBerita::class, 'slug', ignoreRecord: true),
            ]);
    }
}
