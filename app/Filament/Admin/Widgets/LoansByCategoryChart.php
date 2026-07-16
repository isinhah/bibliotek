<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Loan;
use Filament\Widgets\ChartWidget;

class LoansByCategoryChart extends ChartWidget
{
    protected ?string $heading = 'Empréstimos por Categoria';

    protected ?string $pollingInterval = '30s';

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $data = Loan::join('books', 'loans.book_id', '=', 'books.id')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->selectRaw('categories.name, count(*) as total')
            ->groupBy('categories.name')
            ->pluck('total', 'categories.name');

        return [
            'datasets' => [
                [
                    'label' => 'Total de Empréstimos',
                    'data' => $data->values()->toArray(),
                    'backgroundColor' => [
                    '#BE123C',
                    '#D97706',
                    '#3B82F6',
                    '#F59E0B',
                    '#856E61',
                    ],
                    'hoverOffset' => 10,
                ],
            ],
            'labels' => $data->keys()->toArray(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
            'cutout' => '70%',
        ];
    }
}
