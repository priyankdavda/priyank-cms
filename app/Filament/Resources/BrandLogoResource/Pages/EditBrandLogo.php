<?php
namespace App\Filament\Resources\BrandLogoResource\Pages;

use App\Filament\Resources\BrandLogoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBrandLogo extends EditRecord
{
    protected static string $resource = BrandLogoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}