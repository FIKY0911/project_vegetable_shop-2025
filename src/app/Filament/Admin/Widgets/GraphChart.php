<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class GraphChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Produk & Transaksi';
    protected static ?int $sort = 1;
    protected static string $color = 'info';

    protected function getData(): array
    {
        // Ambil data transaksi per tanggal
        $transactions = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Ambil data produk per kategori
        $products =  DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name as category', DB::raw('COUNT(*) as total'))
            ->groupBy('categories.name')
            ->orderBy('categories.name')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Transaksi Harian',
                    'data' => $transactions->pluck('total'),
                    'borderColor' => '#3b82f6', // Biru
                    'backgroundColor' => 'transparent',
                    'fill' => false,
                    'tension' => 0.3,
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Jumlah Produk per Kategori',
                    'data' => $products->pluck('total'),
                    'borderColor' => '#facc15', // Kuning
                    'backgroundColor' => 'transparent',
                    'fill' => false,
                    'tension' => 0.4,
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => array_merge(
                $transactions->pluck('date')->map(fn($d) => date('d M', strtotime($d)))->toArray(),
                $products->pluck('category')->map(fn($c) => ucfirst($c))->toArray()
            ),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): ?array
    {
        return [
            'scales' => [
                'y' => [
                    'type' => 'linear',
                    'position' => 'left',
                    'title' => ['display' => true, 'text' => 'Transaksi'],
                ],
                'y1' => [
                    'type' => 'linear',
                    'position' => 'right',
                    'title' => ['display' => true, 'text' => 'Produk'],
                    'grid' => ['drawOnChartArea' => false],
                ],
            ],
        ];
    }
}
