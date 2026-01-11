<?php

namespace App\Filament\Resources\PageResource\Widgets;

use App\Models\Page;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PageStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pages', Page::count())
                ->description('All pages in the system')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Published', Page::where('status', 'published')->count())
                ->description('Live on the website')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Draft', Page::where('status', 'draft')->count())
                ->description('Work in progress')
                ->descriptionIcon('heroicon-m-pencil')
                ->color('warning'),

            Stat::make('Scheduled', Page::where('status', 'scheduled')->count())
                ->description('Waiting to be published')
                ->descriptionIcon('heroicon-m-clock')
                ->color('info'),
        ];
    }
}