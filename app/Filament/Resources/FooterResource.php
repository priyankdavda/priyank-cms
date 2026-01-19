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
                Forms\Components\Grid::make(3)
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
                            ])
                            ->columnSpan(1),

                        Forms\Components\Section::make('Copyright Information')
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
                            ])
                            ->columnSpan(2),
                    ]),

                Forms\Components\Section::make('Footer Links')
                    ->description('Organize your footer navigation links')
                    ->schema([
                        Forms\Components\Grid::make(1)
                            ->schema([
                                Forms\Components\Section::make('Services')
                                    ->schema([
                                        Forms\Components\Repeater::make('services')
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->required()
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('url')
                                                    ->url()
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->columnSpan(2),
                                                Forms\Components\Toggle::make('open_new_tab')
                                                    ->label('New Tab')
                                                    ->inline(false)
                                                    ->default(false),
                                            ])
                                            ->columns(3)
                                            ->defaultItems(0)
                                            ->collapsed()
                                            ->cloneable()
                                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'Service Link')
                                            ->addActionLabel('Add Service Link'),
                                    ])
                                    ->collapsible()
                                    ->columnSpan(1),

                                Forms\Components\Section::make('Information')
                                    ->schema([
                                        Forms\Components\Repeater::make('information')
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->required()
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('url')
                                                    ->url()
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->columnSpan(2),
                                                Forms\Components\Toggle::make('open_new_tab')
                                                    ->label('New Tab')
                                                    ->inline(false)
                                                    ->default(false),
                                            ])
                                            ->columns(3)
                                            ->defaultItems(0)
                                            ->collapsed()
                                            ->cloneable()
                                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'Info Link')
                                            ->addActionLabel('Add Info Link'),
                                    ])
                                    ->collapsible()
                                    ->columnSpan(1),

                                Forms\Components\Section::make('Resources')
                                    ->schema([
                                        Forms\Components\Repeater::make('resources')
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->required()
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('url')
                                                    ->url()
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->columnSpan(2),
                                                Forms\Components\Toggle::make('open_new_tab')
                                                    ->label('New Tab')
                                                    ->inline(false)
                                                    ->default(false),
                                            ])
                                            ->columns(3)
                                            ->defaultItems(0)
                                            ->collapsed()
                                            ->cloneable()
                                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'Resource Link')
                                            ->addActionLabel('Add Resource Link'),
                                    ])
                                    ->collapsible()
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Social Media Links')
                    ->description('Add your social media profiles')
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
                                    ->searchable()
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('url')
                                    ->url()
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('https://facebook.com/yourpage')
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('icon')
                                    ->maxLength(255)
                                    ->placeholder('fa-facebook')
                                    ->helperText('Optional: Custom icon class')
                                    ->columnSpan(1),
                            ])
                            ->columns(4)
                            ->defaultItems(0)
                            ->collapsed()
                            ->cloneable()
                            ->itemLabel(fn (array $state): ?string => ucfirst($state['platform'] ?? 'Social Link'))
                            ->addActionLabel('Add Social Media Link')
                            ->grid(2),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Contact Information')
                    ->description('Business contact details displayed in footer')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Fieldset::make('Address')
                                    ->schema([
                                        Forms\Components\TextInput::make('contact_info.address.line1')
                                            ->label('Address Line 1')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('contact_info.address.line2')
                                            ->label('Address Line 2')
                                            ->maxLength(255),
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('contact_info.address.city')
                                                    ->label('City')
                                                    ->maxLength(100),
                                                Forms\Components\TextInput::make('contact_info.address.country')
                                                    ->label('Country')
                                                    ->maxLength(100),
                                            ]),
                                    ]),

                                Forms\Components\Fieldset::make('Contact Details')
                                    ->schema([
                                        Forms\Components\TextInput::make('contact_info.phone')
                                            ->label('Phone Number')
                                            ->tel()
                                            ->maxLength(50)
                                            ->placeholder('+1 (555) 123-4567'),
                                        Forms\Components\TextInput::make('contact_info.email')
                                            ->label('Email Address')
                                            ->email()
                                            ->maxLength(255)
                                            ->placeholder('contact@example.com'),
                                    ]),
                            ]),
                    ])
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