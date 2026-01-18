<?php

namespace App\Filament\Resources\CaseStudyResource\Pages;

use App\Filament\Resources\CaseStudyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCaseStudies extends ListRecords
{
    protected static string $resource = CaseStudyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    
    public function getTabs(): array
    {
        return [
            'all' => ListRecords\Tab::make('All')
                ->badge(fn () => $this->getModel()::count()),
                
            'published' => ListRecords\Tab::make('Published')
                ->modifyQueryUsing(fn ($query) => $query->where('is_published', true))
                ->badge(fn () => $this->getModel()::where('is_published', true)->count())
                ->badgeColor('success'),
                
            'draft' => ListRecords\Tab::make('Draft')
                ->modifyQueryUsing(fn ($query) => $query->where('is_published', false))
                ->badge(fn () => $this->getModel()::where('is_published', false)->count())
                ->badgeColor('warning'),
                
            'featured' => ListRecords\Tab::make('Featured')
                ->modifyQueryUsing(fn ($query) => $query->where('is_featured', true))
                ->badge(fn () => $this->getModel()::where('is_featured', true)->count())
                ->badgeColor('info'),
        ];
    }
}



