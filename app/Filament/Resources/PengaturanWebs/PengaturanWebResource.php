<?php

namespace App\Filament\Resources\PengaturanWebs;

use App\Filament\Resources\PengaturanWebs\Pages\CreatePengaturanWeb;
use App\Filament\Resources\PengaturanWebs\Pages\EditPengaturanWeb;
use App\Filament\Resources\PengaturanWebs\Pages\ListPengaturanWebs;
use App\Filament\Resources\PengaturanWebs\Schemas\PengaturanWebForm;
use App\Filament\Resources\PengaturanWebs\Tables\PengaturanWebsTable;
use App\Models\PengaturanWeb;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PengaturanWebResource extends Resource
{
    protected static ?string $model = PengaturanWeb::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama_website';

    public static function form(Schema $schema): Schema
    {
        return PengaturanWebForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengaturanWebsTable::configure($table);
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
            'index' => ListPengaturanWebs::route('/'),
            'create' => CreatePengaturanWeb::route('/create'),
            'edit' => EditPengaturanWeb::route('/{record}/edit'),
        ];
    }
}
