<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FooterResource\Pages;
use App\Models\Footer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FooterResource extends Resource
{
    protected static ?string $model = Footer::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('General Settings')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active Footer')
                            ->default(true)
                            ->helperText('Only one footer can be active at a time'),
                    ])->columns(2),

                Forms\Components\Tabs::make('Footer Content')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Services')
                            ->schema([
                                Forms\Components\Repeater::make('services')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('url')
                                            ->url()
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Toggle::make('open_new_tab')
                                            ->default(false),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(0)
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                            ]),

                        Forms\Components\Tabs\Tab::make('Information')
                            ->schema([
                                Forms\Components\Repeater::make('information')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('url')
                                            ->url()
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Toggle::make('open_new_tab')
                                            ->default(false),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(0)
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                            ]),

                        Forms\Components\Tabs\Tab::make('Resources')
                            ->schema([
                                Forms\Components\Repeater::make('resources')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('url')
                                            ->url()
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Toggle::make('open_new_tab')
                                            ->default(false),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(0)
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                            ]),

                        Forms\Components\Tabs\Tab::make('Social Media')
                            ->schema([
                                Forms\Components\Repeater::make('social_links')
                                    ->schema([
                                        Forms\Components\Select::make('platform')
                                            ->required()
                                            ->options([
                                                'facebook' => 'Facebook',
                                                'twitter' => 'Twitter',
                                                'linkedin' => 'LinkedIn',
                                                'youtube' => 'YouTube',
                                                'instagram' => 'Instagram',
                                                'tiktok' => 'TikTok',
                                                'github' => 'GitHub',
                                            ])
                                            ->searchable(),
                                        Forms\Components\TextInput::make('url')
                                            ->url()
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('https://facebook.com/yourpage'),
                                        Forms\Components\TextInput::make('icon')
                                            ->maxLength(255)
                                            ->helperText('Optional: Custom icon class or SVG'),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(0)
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => ucfirst($state['platform'] ?? 'Social Link')),
                            ]),

                        Forms\Components\Tabs\Tab::make('Contact Info')
                            ->schema([
                                Forms\Components\Section::make('Address')
                                    ->schema([
                                        Forms\Components\TextInput::make('contact_info.address.line1')
                                            ->label('Address Line 1')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('contact_info.address.line2')
                                            ->label('Address Line 2')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('contact_info.address.city')
                                            ->label('City')
                                            ->maxLength(100),
                                        Forms\Components\TextInput::make('contact_info.address.country')
                                            ->label('Country')
                                            ->maxLength(100),
                                    ])->columns(2),

                                Forms\Components\Section::make('Contact Details')
                                    ->schema([
                                        Forms\Components\TextInput::make('contact_info.phone')
                                            ->label('Phone Number')
                                            ->tel()
                                            ->maxLength(50),
                                        Forms\Components\TextInput::make('contact_info.email')
                                            ->label('Email Address')
                                            ->email()
                                            ->maxLength(255),
                                    ])->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('Copyright')
                            ->schema([
                                Forms\Components\TextInput::make('copyright_text')
                                    ->label('Copyright Text')
                                    ->maxLength(255)
                                    ->placeholder('Fusion Logic, All rights reserved.')
                                    ->helperText('Text to display in the copyright notice'),
                                Forms\Components\TextInput::make('copyright_year')
                                    ->label('Copyright Year')
                                    ->numeric()
                                    ->default(now()->year)
                                    ->minValue(2000)
                                    ->maxValue(2100),
                            ])->columns(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('copyright_text')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('copyright_year')
                    ->label('Year')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFooters::route('/'),
            'create' => Pages\CreateFooter::route('/create'),
            'edit' => Pages\EditFooter::route('/{record}/edit'),
        ];
    }
}