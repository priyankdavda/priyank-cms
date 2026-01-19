<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use App\Filament\Resources\ContactResource\Widgets\ContactStatsWidget;
use App\Filament\Resources\ContactResource\Widgets\RecentContactsWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ContactStatsWidget::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            
            'new' => Tab::make('New')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'new'))
                ->badge(fn () => static::getResource()::getModel()::where('status', 'new')->count())
                ->badgeColor('warning'),
            
            'in_progress' => Tab::make('In Progress')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'in_progress'))
                ->badge(fn () => static::getResource()::getModel()::where('status', 'in_progress')->count())
                ->badgeColor('info'),
            
            'resolved' => Tab::make('Resolved')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'resolved'))
                ->badge(fn () => static::getResource()::getModel()::where('status', 'resolved')->count())
                ->badgeColor('success'),
            
            'unassigned' => Tab::make('Unassigned')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('assigned_to'))
                ->badge(fn () => static::getResource()::getModel()::whereNull('assigned_to')->count())
                ->badgeColor('danger'),
            
            'high_priority' => Tab::make('High Priority')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('priority', ['high', 'urgent']))
                ->badge(fn () => static::getResource()::getModel()::whereIn('priority', ['high', 'urgent'])->count())
                ->badgeColor('danger'),
        ];
    }
}
