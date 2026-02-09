<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use App\Models\ServiceCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Services';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                        
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        
                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->options(ServiceCategory::active()->pluck('name', 'id'))
                            ->searchable()
                            ->preload(),
                        
                        Forms\Components\Textarea::make('short_description')
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Content')
                    ->schema([
                        Forms\Components\RichEditor::make('description')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'heading',
                                'bulletList',
                                'orderedList',
                                'blockquote',
                                'codeBlock',
                            ])
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('featured_image')
                            ->image()
                            ->maxSize(2048)
                            ->directory('services/featured'),
                        
                        Forms\Components\TextInput::make('icon')
                            ->helperText('Icon class (e.g., heroicon-o-star)'),
                        
                        Forms\Components\TextInput::make('video_link')
                            ->label('Video Link')
                            ->url()
                            ->helperText('YouTube, Vimeo, or other video URL')
                            ->columnSpanFull(),
                        
                        Forms\Components\FileUpload::make('gallery')
                            ->multiple()
                            ->image()
                            ->maxSize(2048)
                            ->maxFiles(10)
                            ->directory('services/gallery')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                // Forms\Components\Section::make('Pricing')
                //     ->schema([
                //         Forms\Components\TextInput::make('price')
                //             ->numeric()
                //             ->prefix('$')
                //             ->maxValue(999999.99),
                        
                //         Forms\Components\Select::make('price_type')
                //             ->options([
                //                 'fixed' => 'Fixed Price',
                //                 'starting_from' => 'Starting From',
                //                 'contact' => 'Contact for Pricing',
                //             ])
                //             ->default('fixed'),
                        
                //         Forms\Components\TextInput::make('duration')
                //             ->helperText('e.g., "2 weeks", "1 month", "Per hour"'),
                //     ])
                //     ->columns(3),

                Forms\Components\Section::make('Features')
                    ->schema([
                        Forms\Components\Repeater::make('features')
                            ->schema([
                                Forms\Components\TextInput::make('feature')
                                    ->required(),
                            ])
                            ->defaultItems(0)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Content Blocks')
                    ->schema([
                        Forms\Components\TextInput::make('content_blocks_tagline')
                            ->label('Section Tagline')
                            ->helperText('A catchy tagline/heading for the entire content blocks section')
                            ->columnSpanFull(),
                        
                        Forms\Components\Repeater::make('content_blocks')
                            ->schema([
                                
                                Forms\Components\FileUpload::make('thumbnail')
                                ->label('Thumbnail')
                                ->image()
                                ->maxSize(2048)
                                ->directory('services/content-blocks')
                                ->columnSpanFull(),

                                Forms\Components\TextInput::make('heading')
                                    ->label('Heading')
                                    ->required()
                                    ->columnSpanFull(),
                                
                                Forms\Components\Textarea::make('description')
                                    ->label('Short Description')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])
                            ->orderable()
                            ->reorderable()
                            ->defaultItems(0)
                            ->columnSpanFull(),
                    ])
                    ->collapsed(),

                Forms\Components\Section::make('Q&A')
                    ->schema([
                        Forms\Components\TextInput::make('qna_heading')
                            ->label('Section Heading')
                            ->helperText('Main heading for the Q&A section')
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('qna_tagline')
                            ->label('Section Tagline')
                            ->helperText('A descriptive tagline for the Q&A section')
                            ->columnSpanFull(),
                        
                        Forms\Components\Repeater::make('qna')
                            ->label('Questions & Answers')
                            ->schema([
                                Forms\Components\TextInput::make('question')
                                    ->label('Question Heading')
                                    ->required()
                                    ->columnSpanFull(),
                                
                                Forms\Components\Textarea::make('answer')
                                    ->label('Short Answer')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])
                            ->orderable()
                            ->reorderable()
                            ->defaultItems(0)
                            ->columnSpanFull(),
                    ])
                    ->collapsed(),

                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->maxLength(60),
                        
                        Forms\Components\Textarea::make('meta_description')
                            ->maxLength(160)
                            ->rows(3),
                        
                        Forms\Components\TagsInput::make('meta_keywords')
                            ->separator(','),
                    ])
                    ->collapsed(),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Higher number = appears first'),
                        
                        Forms\Components\Toggle::make('is_featured')
                            ->default(false),
                        
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                        
                        Forms\Components\DateTimePicker::make('published_at')
                            ->default(now()),
                    ])
                    ->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->circular(),
                
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('category.name')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured'),
                
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
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
            ->defaultSort('order', 'desc');
    }

    // public static function getRelations(): array
    // {
    //     return [
    //         RelationManagers\FaqsRelationManager::class,
    //         RelationManagers\TestimonialsRelationManager::class,
    //         RelationManagers\InquiriesRelationManager::class,
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
            'view' => Pages\ViewService::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}