<?php

namespace App\Filament\Resources\RealisasiPrograms;

use App\Filament\Resources\RealisasiPrograms\Pages\CreateRealisasiProgram;
use App\Filament\Resources\RealisasiPrograms\Pages\EditRealisasiProgram;
use App\Filament\Resources\RealisasiPrograms\Pages\ListRealisasiPrograms;
use App\Filament\Resources\RealisasiPrograms\Schemas\RealisasiProgramForm;
use App\Filament\Resources\RealisasiPrograms\Tables\RealisasiProgramsTable;
use App\Models\RealisasiProgram;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RealisasiProgramResource extends Resource
{
    protected static ?string $model = RealisasiProgram::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama_lokal';

    protected static ?string $navigationLabel = 'Daftar Program Kerja';

    protected static \UnitEnum|string|null $navigationGroup = 'Dep. Organisasi';

    public static function form(Schema $schema): Schema
    {
        return RealisasiProgramForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RealisasiProgramsTable::configure($table);
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
            'index' => ListRealisasiPrograms::route('/'),
            'create' => CreateRealisasiProgram::route('/create'),
            'edit' => EditRealisasiProgram::route('/{record}/edit'),
        ];
    }
}
