<?php

namespace App\Filament\Resources\RealisasiPrograms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RealisasiProgramsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kategori.nama_kategori')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama_lokal')
                    ->label('Nama Kegiatan')
                    ->searchable(),

                TextColumn::make('pac.name')
                    ->label('PAC')
                    ->searchable()
                    ->sortable()
                    ->badge(),

                TextColumn::make('tgl_mulai')
                    ->label('Waktu Pelaksanaan')
                    ->formatStateUsing(fn($record) => $record->tgl_mulai->format('d M') . ' - ' . $record->tgl_selesai->format('d M Y'))
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Rencana' => 'gray',
                        'Pasti' => 'warning',
                        'Terlaksana' => 'success',
                    }),

                IconColumn::make('is_fix')
                    ->label('Jadwal Fix')
                    ->boolean()
                    ->trueIcon('heroicon-o-lock-closed')
                    ->falseIcon('heroicon-o-lock-open'),

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
                \Filament\Tables\Filters\SelectFilter::make('pac_id')
                    ->label('Filter per PAC')
                    ->relationship('pac', 'name')
                    ->searchable()
                    ->preload(),
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
