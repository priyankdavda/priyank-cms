<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageSeoResource\Pages;
use App\Filament\Resources\PageSeoResource\RelationManagers;
use App\Models\PageSeo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PageSeoResource extends Resource
{
    protected static ?string $model = PageSeo::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $navigationLabel = 'Page SEO';

    protected static ?string $modelLabel = 'Page SEO';

    protected static ?string $pluralModelLabel = 'Page SEO Settings';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Page Information')
                    ->description('Identify the page for SEO management')
                    ->schema([
                        Forms\Components\TextInput::make('page_name')
                            ->label('Page Display Name')
                            ->required()
                            ->maxLength(255)
                            ->helperText('E.g., "Homepage", "About Us", "Contact"')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, ?string $old) {
                                if (empty($old)) {
                                    $set('page_identifier', Str::slug($state));
                                }
                            }),
                        
                        Forms\Components\TextInput::make('page_identifier')
                            ->label('Page Identifier (Slug)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Unique identifier (e.g., "home", "about-us"). This will be used in code.')
                            ->regex('/^[a-z0-9-]+$/')
                            ->validationMessages([
                                'regex' => 'Only lowercase letters, numbers, and hyphens are allowed.',
                            ]),
                        
                        Forms\Components\TextInput::make('page_url')
                            ->label('Page URL')
                            ->url()
                            ->maxLength(255)
                            ->helperText('Optional: The actual URL for reference'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Basic SEO')
                    ->description('Primary SEO meta tags')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Meta Title')
                            ->maxLength(60)
                            ->helperText('Recommended: 50-60 characters')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                if (empty($get('og_title'))) {
                                    $set('og_title', $state);
                                }
                                if (empty($get('twitter_title'))) {
                                    $set('twitter_title', $state);
                                }
                            }),
                        
                        Forms\Components\Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->maxLength(160)
                            ->rows(3)
                            ->helperText('Recommended: 150-160 characters')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                if (empty($get('og_description'))) {
                                    $set('og_description', $state);
                                }
                                if (empty($get('twitter_description'))) {
                                    $set('twitter_description', $state);
                                }
                            }),
                        
                        Forms\Components\TextInput::make('canonical')
                            ->label('Canonical URL')
                            ->url()
                            ->maxLength(255)
                            ->helperText('The preferred version of the page URL'),
                        
                        Forms\Components\TagsInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->helperText('Comma-separated keywords (optional, less important for SEO)')
                            ->separator(','),
                        
                        Forms\Components\TextInput::make('meta_robots')
                            ->label('Meta Robots')
                            ->maxLength(255)
                            ->default('index, follow')
                            ->helperText('E.g., "index, follow" or "noindex, nofollow"'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Open Graph (Facebook, LinkedIn)')
                    ->description('Social sharing metadata for Facebook, LinkedIn, etc.')
                    ->schema([
                        Forms\Components\TextInput::make('og_title')
                            ->label('OG Title')
                            ->maxLength(95)
                            ->helperText('Falls back to Meta Title if empty'),
                        
                        Forms\Components\Textarea::make('og_description')
                            ->label('OG Description')
                            ->maxLength(200)
                            ->rows(3)
                            ->helperText('Falls back to Meta Description if empty'),
                        
                        Forms\Components\FileUpload::make('og_image')
                            ->label('OG Image')
                            ->image()
                            ->maxSize(2048)
                            ->directory('seo/og-images')
                            ->helperText('Recommended: 1200x630px'),
                    ])
                    ->columns(1)
                    ->collapsed(),

                Forms\Components\Section::make('Twitter Card')
                    ->description('Social sharing metadata for Twitter/X')
                    ->schema([
                        Forms\Components\TextInput::make('twitter_title')
                            ->label('Twitter Title')
                            ->maxLength(70)
                            ->helperText('Falls back to Meta Title if empty'),
                        
                        Forms\Components\Textarea::make('twitter_description')
                            ->label('Twitter Description')
                            ->maxLength(200)
                            ->rows(3)
                            ->helperText('Falls back to Meta Description if empty'),
                        
                        Forms\Components\FileUpload::make('twitter_image')
                            ->label('Twitter Image')
                            ->image()
                            ->maxSize(2048)
                            ->directory('seo/twitter-images')
                            ->helperText('Recommended: 1200x675px'),
                    ])
                    ->columns(1)
                    ->collapsed(),

                Forms\Components\Section::make('Advanced')
                    ->schema([
                        Forms\Components\Textarea::make('schema_markup')
                            ->label('Schema Markup (JSON-LD)')
                            ->rows(10)
                            ->helperText('Optional: Structured data in JSON-LD format')
                            ->columnSpanFull(),
                    ])
                    ->collapsed(),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Only active SEO settings will be used on the frontend'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('page_name')
                    ->label('Page Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('page_identifier')
                    ->label('Identifier')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Meta Title')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active')
                    ->placeholder('All')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('page_name');
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
            'index' => Pages\ListPageSeos::route('/'),
            'create' => Pages\CreatePageSeo::route('/create'),
            'edit' => Pages\EditPageSeo::route('/{record}/edit'),
            'view' => Pages\ViewPageSeo::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
