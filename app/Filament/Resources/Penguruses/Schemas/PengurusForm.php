<?php

namespace App\Filament\Resources\Penguruses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PengurusForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kader_id')
                    ->required()
                    ->numeric(),
                TextInput::make('surat_keputusan_id')
                    ->required()
                    ->numeric(),
                TextInput::make('tingkatan')
                    ->required(),
                TextInput::make('nama_tingkatan')
                    ->required(),
                \Filament\Forms\Components\Select::make('parent_id')
                    ->relationship('parent', 'id', function ($query) {
                        return $query->with('kader')->select('pengurus.*');
                    })
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->jabatan} - {$record->kader->nama_lengkap}")
                    ->searchable()
                    ->preload()
                    ->label('Atasan Langsung'),
                TextInput::make('jabatan')
                    ->required(),
                TextInput::make('departemen'),
            ]);
    }
}
