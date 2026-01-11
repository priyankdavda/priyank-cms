<?php
namespace App\Filament\Resources\BrandLogoResource\Pages;

use App\Filament\Resources\BrandLogoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBrandLogo extends CreateRecord
{
    protected static string $resource = BrandLogoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
