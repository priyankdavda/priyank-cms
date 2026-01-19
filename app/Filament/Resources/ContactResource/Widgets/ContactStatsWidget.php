<?php

namespace App\Filament\Resources\ContactResource\Widgets;

use App\Models\Contact;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContactStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $newContacts = Contact::where('status', 'new')->count();
        $inProgress = Contact::where('status', 'in_progress')->count();
        $resolvedToday = Contact::where('status', 'resolved')
            ->whereDate('resolved_at', today())
            ->count();
        $totalContacts = Contact::count();

        return [
            Stat::make('New Contacts', $newContacts)
                ->description('Awaiting response')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('warning')
                ->chart($this->getLastSevenDaysData('new')),

            Stat::make('In Progress', $inProgress)
                ->description('Being handled')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('info')
                ->chart($this->getLastSevenDaysData('in_progress')),

            Stat::make('Resolved Today', $resolvedToday)
                ->description('Completed today')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Contacts', $totalContacts)
                ->description('All time')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
        ];
    }

    protected function getLastSevenDaysData(string $status): array
    {
        $data = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $count = Contact::where('status', $status)
                ->whereDate('created_at', $date)
                ->count();
            $data[] = $count;
        }
        
        return $data;
    }
}