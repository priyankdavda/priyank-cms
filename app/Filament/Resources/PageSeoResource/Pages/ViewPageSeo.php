<?php

namespace App\Filament\Resources\PageSeoResource\Pages;

use App\Filament\Resources\PageSeoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPageSeo extends ViewRecord
{
    protected static string $resource = PageSeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
