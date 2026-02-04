<?php

namespace App\Filament\Resources\SuratKeputusans;

use App\Filament\Resources\SuratKeputusans\Pages\CreateSuratKeputusan;
use App\Filament\Resources\SuratKeputusans\Pages\EditSuratKeputusan;
use App\Filament\Resources\SuratKeputusans\Pages\ListSuratKeputusans;
use App\Filament\Resources\SuratKeputusans\Schemas\SuratKeputusanForm;
use App\Filament\Resources\SuratKeputusans\Tables\SuratKeputusansTable;
use App\Models\SuratKeputusan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SuratKeputusanResource extends Resource
{
    protected static ?string $model = SuratKeputusan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'judul_sk';

    public static function form(Schema $schema): Schema
    {
        return SuratKeputusanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SuratKeputusansTable::configure($table);
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
            'index' => ListSuratKeputusans::route('/'),
            'create' => CreateSuratKeputusan::route('/create'),
            'edit' => EditSuratKeputusan::route('/{record}/edit'),
        ];
    }
}
