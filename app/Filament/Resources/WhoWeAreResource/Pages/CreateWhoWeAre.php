<?php

namespace App\Filament\Resources\WhoWeAreResource\Pages;

use App\Filament\Resources\WhoWeAreResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWhoWeAre extends CreateRecord
{
    protected static string $resource = WhoWeAreResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
