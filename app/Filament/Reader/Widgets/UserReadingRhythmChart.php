<?php

namespace App\Filament\Reader\Widgets;

use App\Models\Loan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class UserReadingRhythmChart extends ChartWidget
{
    protected ?string $heading = 'Seu Ritmo de Leitura';

    protected function getType(): string { return 'line'; }

    protected function getData(): array
    {
        $userId = auth()->id();

        $data = Loan::where('user_id', $userId)
            ->whereYear('created_at', date('Y'))
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->pluck('total', 'month');

        $months = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        $labels = $data->keys()->map(fn($m) => $months[$m - 1])->toArray();

        return [
            'datasets' => [[
                'label' => 'Livros por mês',
                'data' => $data->values()->toArray(),
                'borderColor' => '#BE123C',
                'backgroundColor' => 'rgba(190, 18, 60, 0.15)',
                'tension' => 0.4,
            ]],
            'labels' => $labels,
        ];
    }
}
