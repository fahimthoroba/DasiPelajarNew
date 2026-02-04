<?php

namespace App\Filament\Resources\KategoriPrograms;

use App\Filament\Resources\KategoriPrograms\Pages\CreateKategoriProgram;
use App\Filament\Resources\KategoriPrograms\Pages\EditKategoriProgram;
use App\Filament\Resources\KategoriPrograms\Pages\ListKategoriPrograms;
use App\Filament\Resources\KategoriPrograms\Schemas\KategoriProgramForm;
use App\Filament\Resources\KategoriPrograms\Tables\KategoriProgramsTable;
use App\Models\KategoriProgram;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KategoriProgramResource extends Resource
{
    protected static ?string $model = KategoriProgram::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama_kategori';

    protected static bool $shouldRegisterNavigation = false;

    protected static \UnitEnum|string|null $navigationGroup = 'Dep. Organisasi';

    public static function form(Schema $schema): Schema
    {
        return KategoriProgramForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KategoriProgramsTable::configure($table);
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
            'index' => ListKategoriPrograms::route('/'),
            'create' => CreateKategoriProgram::route('/create'),
            'edit' => EditKategoriProgram::route('/{record}/edit'),
        ];
    }
}
