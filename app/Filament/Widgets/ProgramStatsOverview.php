<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProgramStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Program Kerja', \App\Models\RealisasiProgram::count())
                ->description('Semua rencana dan realisasi')
                ->descriptionIcon('heroicon-m-inbox-stack')
                ->color('success'),

            Stat::make('Kegiatan Bulan Ini', \App\Models\RealisasiProgram::whereMonth('tgl_mulai', now()->month)->count())
                ->description(now()->format('F Y'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),

            Stat::make('PAC Aktif', \App\Models\RealisasiProgram::distinct('pac_id')->count('pac_id'))
                ->description('Jumlah PAC yang sudah input proker')
                ->color('warning'),
        ];
    }
}
