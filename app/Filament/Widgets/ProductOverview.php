<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //
            Stat::make("Total Products", Product::count())
            ->description('Last 13 days')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart(
                collect(range(12, 0))->map(fn ($i) =>
                    Product::whereDate('created_at', Carbon::today()->subDays($i))->count()
                )->toArray()
            )
            ->color('success'),

        Stat::make("Total Categories", Category::count())
            ->description('Last 6 days')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart(
                collect(range(6, 0))->map(fn ($i) =>
                    Category::whereDate('created_at', Carbon::today()->subDays($i))->count()
                )->toArray()
            )
            ->color('info'),

        Stat::make("Total Purchases", Purchase::count())
            ->description('Last 6 days')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart(
                collect(range(6, 0))->map(fn ($i) =>
                    Purchase::whereDate('created_at', Carbon::today()->subDays($i))->count()
                )->toArray()
            )
            ->color('warning'),
    ];
    }
}
