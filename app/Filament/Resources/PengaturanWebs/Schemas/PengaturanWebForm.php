<?php

namespace App\Filament\Resources\PengaturanWebs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PengaturanWebForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_website')
                    ->required()
                    ->default('PC IPNU IPPNU Kediri'),
                Textarea::make('deskripsi_singkat')
                    ->label('Deksripsi Footer')
                    ->columnSpanFull(),
                \Filament\Forms\Components\RichEditor::make('profil_singkat')
                    ->columnSpanFull(),
                \Filament\Forms\Components\RichEditor::make('visi')
                    ->columnSpanFull(),
                \Filament\Forms\Components\RichEditor::make('misi')
                    ->columnSpanFull(),
                \Filament\Forms\Components\FileUpload::make('logo_path')
                    ->image()
                    ->disk('public')
                    ->directory('settings'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('no_wa'),
                TextInput::make('alamat'),
                TextInput::make('facebook'),
                TextInput::make('instagram'),
                TextInput::make('youtube'),
                TextInput::make('tiktok'),
            ]);
    }
}
