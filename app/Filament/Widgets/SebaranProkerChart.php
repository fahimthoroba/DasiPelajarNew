<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class SebaranProkerChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Kepadatan Program per Bulan';

    protected function getData(): array
    {
        $data = \App\Models\RealisasiProgram::selectRaw('MONTH(tgl_mulai) as month, COUNT(*) as count')
            ->whereYear('tgl_mulai', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Fill missing months with 0
        $counts = [];
        for ($i = 1; $i <= 12; $i++) {
            $counts[] = $data[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Program Kerja',
                    'data' => $counts,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
