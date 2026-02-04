<?php

namespace App\Filament\Resources\Beritas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BeritaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('kategori_berita_id')
                    ->relationship('kategoriBerita', 'nama')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        \Filament\Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(string $operation, $state, $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                        \Filament\Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(\App\Models\KategoriBerita::class, 'slug', ignoreRecord: true),
                    ])
                    ->required(),
                \Filament\Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->default(auth()->id())
                    ->required(),
                TextInput::make('judul')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(string $operation, $state, $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                TextInput::make('slug')
                    ->required()
                    ->unique(\App\Models\Berita::class, 'slug', ignoreRecord: true),
                \Filament\Forms\Components\FileUpload::make('thumbnail')
                    ->image()
                    ->disk('public')
                    ->directory('berita-thumbnails'),
                \Filament\Forms\Components\RichEditor::make('konten')
                    ->required()
                    ->columnSpanFull(),
                \Filament\Forms\Components\Select::make('status')
                    ->options([
                        'Draft' => 'Draft',
                        'Published' => 'Published',
                    ])
                    ->required()
                    ->default('Draft'),
                DatePicker::make('tgl_publish'),
            ]);
    }
}
