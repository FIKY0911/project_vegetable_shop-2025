<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class GraphChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Produk & Transaksi';
    protected static ?int $sort = 1;
    protected static string $color = 'info';

    protected function getData(): array
    {
        // Data transaksi harian
        $transactions = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Data produk per kategori
        $products = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name as category', DB::raw('COUNT(products.id) as total'))
            ->groupBy('categories.name')
            ->orderBy('categories.name')
            ->get();

        // Label tanggal transaksi
        $transactionLabels = $transactions->pluck('date')->map(
            fn($d) => date('d M', strtotime($d))
        )->toArray();

        // Label kategori produk
        $productLabels = $products->pluck('category')->map(
            fn($c) => ucfirst($c)
        )->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Transaksi Harian',
                    'data' => $transactions->pluck('total'),
                    'borderColor' => '#3b82f6', // biru
                    'backgroundColor' => 'transparent',
                    'fill' => false,
                    'tension' => 0.4,
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Produk per Kategori',
                    'data' => $products->pluck('total'),
                    'borderColor' => '#facc15', // kuning
                    'backgroundColor' => 'transparent',
                    'fill' => false,
                    'tension' => 0.4,
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => array_merge($transactionLabels, $productLabels),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): ?array
    {
        return [
            'responsive' => true,
            'scales' => [
                'y' => [
                    'type' => 'linear',
                    'position' => 'left',
                    'title' => [
                        'display' => true,
                        'text' => 'Jumlah Transaksi',
                    ],
                ],
                'y1' => [
                    'type' => 'linear',
                    'position' => 'right',
                    'title' => [
                        'display' => true,
                        'text' => 'Jumlah Produk',
                    ],
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
            ],
        ];
    }

    protected function getPollingInterval(): ?string
    {
        return '5s';
    }
}
