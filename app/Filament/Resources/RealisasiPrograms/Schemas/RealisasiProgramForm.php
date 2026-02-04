<?php

namespace App\Filament\Resources\RealisasiPrograms\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class RealisasiProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Hidden: PAC ID diisi otomatis di controller/CreateRecord
                Hidden::make('pac_id')
                    ->default(fn() => auth()->id()),

                Select::make('kategori_program_id')
                    ->label('Kategori Induk Program')
                    ->relationship('kategori', 'nama_kategori', fn($query) => $query->where('status_verifikasi', true))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        TextInput::make('nama_kategori')
                            ->required()
                            ->label('Nama Kategori Baru')
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(string $operation, $state, Set $set) => $set('slug', Str::slug($state))),

                        Hidden::make('slug'),

                        Select::make('departemen_id')
                            ->relationship('departemen', 'nama_departemen')
                            ->required(),

                        Hidden::make('dibuat_oleh_pac_id')
                            ->default(fn() => auth()->id()),

                        Hidden::make('status_verifikasi')
                            ->default(false),
                    ])
                    ->helperText('Jika kategori program Anda belum ada, silakan buat baru (akan diverifikasi PC).'),

                TextInput::make('nama_lokal')
                    ->label('Nama Kegiatan (Ingenious Name)')
                    ->placeholder('Contoh: Ngopi Santai Bareng Pelajar')
                    ->helperText('Nama kreatif spesifik untuk acara ini.')
                    ->required()
                    ->maxLength(255),

                Grid::make(2)
                    ->schema([
                        DatePicker::make('tgl_mulai')
                            ->label('Tanggal Mulai')
                            ->required(),
                        DatePicker::make('tgl_selesai')
                            ->label('Tanggal Selesai')
                            ->afterOrEqual('tgl_mulai')
                            ->required(),
                    ]),

                Grid::make(2)
                    ->schema([
                        Select::make('status')
                            ->options([
                                'Rencana' => 'Rencana (Belum Pasti)',
                                'Pasti' => 'Pasti (Sudah Terjadwal)',
                                'Terlaksana' => 'Terlaksana (Selesai)',
                            ])
                            ->default('Rencana')
                            ->required(),

                        Toggle::make('is_fix')
                            ->label('Jadwal Fix?')
                            ->helperText('Centang jika tanggal sudah dikunci melalui rapat.')
                            ->inline(false)
                            ->default(false),
                    ]),

                Select::make('target_peserta')
                    ->label('Target Peserta')
                    ->multiple()
                    ->options([
                        'Internal PAC' => 'Internal PAC',
                        'Pengurus Ranting' => 'Pengurus Ranting',
                        'Alumni' => 'Alumni',
                        'Pelajar' => 'Pelajar Umum',
                        'Masyarakat' => 'Masyarakat Umum',
                        'Banom NU Lain' => 'Banom NU Lain',
                    ])
                    ->required(),

                Textarea::make('deskripsi')
                    ->label('Deskripsi Singkat')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
