<?php

namespace App\Filament\Resources\HeroFeatureCardResource\Pages;

use App\Filament\Resources\HeroFeatureCardResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHeroFeatureCard extends EditRecord
{
    protected static string $resource = HeroFeatureCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
