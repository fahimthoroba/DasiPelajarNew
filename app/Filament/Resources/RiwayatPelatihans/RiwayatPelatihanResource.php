<?php

namespace App\Filament\Resources\RiwayatPelatihans;

use App\Filament\Resources\RiwayatPelatihans\Pages\CreateRiwayatPelatihan;
use App\Filament\Resources\RiwayatPelatihans\Pages\EditRiwayatPelatihan;
use App\Filament\Resources\RiwayatPelatihans\Pages\ListRiwayatPelatihans;
use App\Filament\Resources\RiwayatPelatihans\Schemas\RiwayatPelatihanForm;
use App\Filament\Resources\RiwayatPelatihans\Tables\RiwayatPelatihansTable;
use App\Models\RiwayatPelatihan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RiwayatPelatihanResource extends Resource
{
    protected static ?string $model = RiwayatPelatihan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama_pelatihan';

    public static function form(Schema $schema): Schema
    {
        return RiwayatPelatihanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RiwayatPelatihansTable::configure($table);
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
            'index' => ListRiwayatPelatihans::route('/'),
            'create' => CreateRiwayatPelatihan::route('/create'),
            'edit' => EditRiwayatPelatihan::route('/{record}/edit'),
        ];
    }
}
