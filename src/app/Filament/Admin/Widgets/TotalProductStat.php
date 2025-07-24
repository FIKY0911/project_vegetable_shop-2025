<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class TotalProductStat extends BaseWidget
{
    protected ?string $heading = 'Statistik Produk';

    protected function getCards(): array
    {
        $query = Product::query();

        return [
            Card::make('Total Produk', $query->count())
                ->description('Jumlah seluruh produk')
                ->color('info')
                ->icon('heroicon-o-cube'),

            Card::make('Total Stok', $query->sum('stock'))
                ->description('Akumulasi stok semua produk')
                ->color('success')
                ->icon('heroicon-o-archive-box'),

            Card::make('Stok Kosong', $query->where('stock', 0)->count())
                ->description('Produk yang kehabisan stok')
                ->color('danger')
                ->icon('heroicon-o-exclamation-triangle'),
        ];
    }
}
