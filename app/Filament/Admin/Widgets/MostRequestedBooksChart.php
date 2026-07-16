<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Loan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MostRequestedBooksChart extends ChartWidget
{
    protected ?string $heading = 'Top 10 livros mais solicitados';
    protected ?string $pollingInterval = '30s';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $data = Loan::join('books', 'loans.book_id', '=', 'books.id')
            ->select('books.title', DB::raw('count(*) as total'))
            ->groupBy('books.title')
            ->orderBy('total', 'DESC')
            ->limit(10)
            ->pluck('total', 'books.title');

        return [
            'datasets' => [
                [
                    'label' => 'Total de Empréstimos',
                    'data' => $data->values()->toArray(),
                    'backgroundColor' => '#BE123C',
                    'borderRadius' => 0,
                ],
            ],
            'labels' => $data->keys()->toArray(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'scales' => [
                'x' => [
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}
