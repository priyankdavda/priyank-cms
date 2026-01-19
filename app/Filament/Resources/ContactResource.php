<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use App\Models\Service;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Contacts';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'new')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('contact_no')
                            ->label('Contact Number')
                            ->tel()
                            ->maxLength(255),
                        
                        Forms\Components\Select::make('service_id')
                            ->label('Service Interested In')
                            ->relationship('service', 'title')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ])->columns(2),

                Forms\Components\Section::make('Message')
                    ->schema([
                        Forms\Components\Textarea::make('message')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Management')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'new' => 'New',
                                'in_progress' => 'In Progress',
                                'resolved' => 'Resolved',
                                'spam' => 'Spam',
                            ])
                            ->required()
                            ->default('new'),
                        
                        Forms\Components\Select::make('priority')
                            ->options([
                                'low' => 'Low',
                                'normal' => 'Normal',
                                'high' => 'High',
                                'urgent' => 'Urgent',
                            ])
                            ->required()
                            ->default('normal'),
                        
                        Forms\Components\Select::make('assigned_to')
                            ->label('Assigned To')
                            ->relationship('assignedUser', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        
                        Forms\Components\Textarea::make('internal_notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(3),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\TextInput::make('source')
                            ->default('website')
                            ->disabled(),
                        
                        Forms\Components\TextInput::make('ip_address')
                            ->disabled(),
                        
                        Forms\Components\DateTimePicker::make('responded_at')
                            ->label('Responded At'),
                        
                        Forms\Components\DateTimePicker::make('resolved_at')
                            ->label('Resolved At'),
                    ])->columns(2)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),
                
                Tables\Columns\TextColumn::make('contact_no')
                    ->label('Phone')
                    ->searchable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('service.title')
                    ->label('Service')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'primary' => 'new',
                        'warning' => 'in_progress',
                        'success' => 'resolved',
                        'danger' => 'spam',
                    ])
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('priority')
                    ->badge()
                    ->colors([
                        'danger' => 'urgent',
                        'warning' => 'high',
                        'info' => 'normal',
                        'secondary' => 'low',
                    ])
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('assignedUser.name')
                    ->label('Assigned To')
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('responded_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'in_progress' => 'In Progress',
                        'resolved' => 'Resolved',
                        'spam' => 'Spam',
                    ])
                    ->multiple(),
                
                Tables\Filters\SelectFilter::make('priority')
                    ->options([
                        'low' => 'Low',
                        'normal' => 'Normal',
                        'high' => 'High',
                        'urgent' => 'Urgent',
                    ])
                    ->multiple(),
                
                Tables\Filters\SelectFilter::make('service_id')
                    ->label('Service')
                    ->relationship('service', 'title')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                
                Tables\Filters\SelectFilter::make('assigned_to')
                    ->label('Assigned To')
                    ->relationship('assignedUser', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                
                Tables\Filters\Filter::make('unassigned')
                    ->query(fn (Builder $query): Builder => $query->whereNull('assigned_to'))
                    ->toggle(),
                
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    
                    Tables\Actions\Action::make('markAsResponded')
                        ->label('Mark as Responded')
                        ->icon('heroicon-m-check')
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (Contact $record) => $record->status === 'new')
                        ->action(fn (Contact $record) => $record->markAsResponded()),
                    
                    Tables\Actions\Action::make('markAsResolved')
                        ->label('Mark as Resolved')
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (Contact $record) => $record->status !== 'resolved')
                        ->action(fn (Contact $record) => $record->markAsResolved()),
                    
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('assignTo')
                        ->label('Assign To')
                        ->icon('heroicon-m-user')
                        ->form([
                            Forms\Components\Select::make('assigned_to')
                                ->label('User')
                                ->options(User::pluck('name', 'id'))
                                ->required()
                                ->searchable(),
                        ])
                        ->action(function (array $data, $records) {
                            $records->each->update(['assigned_to' => $data['assigned_to']]);
                        }),
                    
                    Tables\Actions\BulkAction::make('updateStatus')
                        ->label('Update Status')
                        ->icon('heroicon-m-arrow-path')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->options([
                                    'new' => 'New',
                                    'in_progress' => 'In Progress',
                                    'resolved' => 'Resolved',
                                    'spam' => 'Spam',
                                ])
                                ->required(),
                        ])
                        ->action(function (array $data, $records) {
                            $records->each->update(['status' => $data['status']]);
                        }),
                    
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'view' => Pages\ViewContact::route('/{record}'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}