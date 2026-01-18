<?php

namespace App\Filament\Resources\CaseStudyResource\Pages;

use App\Filament\Resources\CaseStudyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCaseStudy extends EditRecord
{
    protected static string $resource = CaseStudyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('toggle_publish')
                ->label(fn () => $this->record->is_published ? 'Unpublish' : 'Publish')
                ->icon(fn () => $this->record->is_published ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                ->color(fn () => $this->record->is_published ? 'warning' : 'success')
                ->action(function () {
                    if ($this->record->is_published) {
                        $this->record->unpublish();
                    } else {
                        $this->record->publish();
                    }
                })
                ->requiresConfirmation(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Case study updated successfully';
    }
}
