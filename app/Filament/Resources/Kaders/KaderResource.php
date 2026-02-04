<?php

namespace App\Filament\Resources\Kaders;

use App\Filament\Resources\Kaders\Pages\CreateKader;
use App\Filament\Resources\Kaders\Pages\EditKader;
use App\Filament\Resources\Kaders\Pages\ListKaders;
use App\Filament\Resources\Kaders\Schemas\KaderForm;
use App\Filament\Resources\Kaders\Tables\KadersTable;
use App\Models\Kader;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KaderResource extends Resource
{
    protected static ?string $model = Kader::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama_lengkap';

    public static function form(Schema $schema): Schema
    {
        return KaderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KadersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKaders::route('/'),
            'create' => CreateKader::route('/create'),
            'edit' => EditKader::route('/{record}/edit'),
        ];
    }
}
