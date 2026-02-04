<?php

namespace App\Filament\Resources\HeroSliders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class HeroSliderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('judul_utama'),
                TextInput::make('sub_judul'),
                \Filament\Forms\Components\FileUpload::make('gambar_path')
                    ->image()
                    ->disk('public')
                    ->directory('hero-sliders')
                    ->required(),
                TextInput::make('link_tombol'),
                TextInput::make('teks_tombol'),
                Toggle::make('show_button')
                    ->default(true)
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('urutan')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
