<?php
namespace App\Filament\Resources\BrandLogoResource\Pages;

use App\Filament\Resources\BrandLogoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrandLogos extends ListRecords
{
    protected static string $resource = BrandLogoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}