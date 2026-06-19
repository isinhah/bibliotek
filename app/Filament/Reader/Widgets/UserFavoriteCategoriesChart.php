<?php

namespace App\Filament\Reader\Widgets;

use App\Models\Loan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class UserFavoriteCategoriesChart extends ChartWidget
{
    protected ?string $heading = 'Top 3 Categorias Favoritas';
    protected ?string $pollingInterval = '60s';

    protected function getType(): string { return 'bar'; }

    protected function getData(): array
    {
        $userId = auth()->id();

        $data = Loan::where('user_id', $userId)
            ->join('books', 'loans.book_id', '=', 'books.id')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('count(*) as total'))
            ->groupBy('categories.name')
            ->orderBy('total', 'DESC')
            ->limit(3)
            ->pluck('total', 'categories.name');

        return [
            'datasets' => [
                [
                    'label' => 'Total de livros',
                    'data' => $data->values()->toArray(),
                    'backgroundColor' => [
                        '#b91c1c',
                        '#065f46',
                        '#581c87',
                    ],
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $data->keys()->toArray(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'x',
            'scales' => [
                'y' => [
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
        ];
    }
}
