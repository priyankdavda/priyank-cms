<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewContact extends ViewRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            
            Actions\Action::make('markAsResponded')
                ->label('Mark as Responded')
                ->icon('heroicon-m-check')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->status === 'new')
                ->action(fn () => $this->record->markAsResponded()),
            
            Actions\Action::make('markAsResolved')
                ->label('Mark as Resolved')
                ->icon('heroicon-m-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->status !== 'resolved')
                ->action(fn () => $this->record->markAsResolved()),
            
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Contact Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->icon('heroicon-m-user'),
                        
                        Infolists\Components\TextEntry::make('email')
                            ->icon('heroicon-m-envelope')
                            ->copyable(),
                        
                        Infolists\Components\TextEntry::make('contact_no')
                            ->label('Phone')
                            ->icon('heroicon-m-phone')
                            ->copyable(),
                        
                        Infolists\Components\TextEntry::make('service.title')
                            ->label('Service Interested In')
                            ->badge()
                            ->color('info'),
                    ])->columns(2),

                Infolists\Components\Section::make('Message')
                    ->schema([
                        Infolists\Components\TextEntry::make('message')
                            ->prose()
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Status & Assignment')
                    ->schema([
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->colors([
                                'primary' => 'new',
                                'warning' => 'in_progress',
                                'success' => 'resolved',
                                'danger' => 'spam',
                            ]),
                        
                        Infolists\Components\TextEntry::make('priority')
                            ->badge()
                            ->colors([
                                'danger' => 'urgent',
                                'warning' => 'high',
                                'info' => 'normal',
                                'secondary' => 'low',
                            ]),
                        
                        Infolists\Components\TextEntry::make('assignedUser.name')
                            ->label('Assigned To')
                            ->default('Unassigned')
                            ->icon('heroicon-m-user'),
                        
                        Infolists\Components\TextEntry::make('source')
                            ->badge(),
                    ])->columns(4),

                Infolists\Components\Section::make('Internal Notes')
                    ->schema([
                        Infolists\Components\TextEntry::make('internal_notes')
                            ->prose()
                            ->columnSpanFull()
                            ->placeholder('No internal notes'),
                    ])
                    ->collapsible(),

                Infolists\Components\Section::make('Timestamps')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime(),
                        
                        Infolists\Components\TextEntry::make('responded_at')
                            ->dateTime()
                            ->placeholder('Not responded yet'),
                        
                        Infolists\Components\TextEntry::make('resolved_at')
                            ->dateTime()
                            ->placeholder('Not resolved yet'),
                        
                        Infolists\Components\TextEntry::make('ip_address')
                            ->label('IP Address')
                            ->copyable(),
                    ])->columns(4)
                    ->collapsible(),
            ]);
    }
}
