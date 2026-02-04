<?php

namespace App\Filament\Resources\KategoriPrograms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KategoriProgramsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_kategori')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Kategori'),

                TextColumn::make('departemen.nama_departemen')
                    ->label('Departemen')
                    ->sortable()
                    ->searchable()
                    ->badge(),

                TextColumn::make('pembuat.name')
                    ->label('Diusulkan Oleh')
                    ->placeholder('Admin PC')
                    ->description(fn($record) => $record->pembuat ? 'PAC' : 'Pusat')
                    ->sortable(),

                \Filament\Tables\Columns\ToggleColumn::make('status_verifikasi')
                    ->label('Verifikasi')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
