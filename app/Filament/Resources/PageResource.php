<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Page Details')
                    ->tabs([
                        // Content Tab
                        Forms\Components\Tabs\Tab::make('Content')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, Forms\Set $set, $context) => 
                                                $context === 'create' ? $set('slug', Str::slug($state)) : null
                                            )
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(Page::class, 'slug', ignoreRecord: true)
                                            ->rules(['alpha_dash'])
                                            ->helperText('URL-friendly version of the title')
                                            ->columnSpanFull(),

                                        Forms\Components\Textarea::make('excerpt')
                                            ->rows(3)
                                            ->maxLength(500)
                                            ->helperText('Brief summary of the page (used as fallback for meta description)')
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('content')
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
                                                'table',
                                                'undo',
                                                'redo',
                                            ])
                                            ->columnSpanFull(),

                                        Forms\Components\FileUpload::make('featured_image')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                '16:9',
                                                '4:3',
                                                '1:1',
                                            ])
                                            ->directory('pages/featured-images')
                                            ->maxSize(2048)
                                            ->helperText('Recommended size: 1200x630px'),

                                        Forms\Components\TextInput::make('featured_image_alt')
                                            ->maxLength(255)
                                            ->helperText('Alt text for the featured image (important for accessibility and SEO)')
                                            ->visible(fn (Get $get) => filled($get('featured_image'))),
                                    ])
                            ]),

                        // SEO Tab
                        Forms\Components\Tabs\Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Forms\Components\Section::make('Basic SEO')
                                    ->description('Primary SEO settings for search engines')
                                    ->schema([
                                        Forms\Components\TextInput::make('meta_title')
                                            ->maxLength(60)
                                            ->helperText('Leave blank to use the page title. Recommended: 50-60 characters')
                                            ->hintAction(
                                                Forms\Components\Actions\Action::make('copyFromTitle')
                                                    ->label('Copy from Title')
                                                    ->icon('heroicon-o-clipboard')
                                                    ->action(function (Forms\Set $set, Get $get) {
                                                        $set('meta_title', $get('title'));
                                                    })
                                            ),

                                        Forms\Components\Textarea::make('meta_description')
                                            ->rows(3)
                                            ->maxLength(160)
                                            ->helperText('Leave blank to use excerpt. Recommended: 150-160 characters')
                                            ->hintAction(
                                                Forms\Components\Actions\Action::make('copyFromExcerpt')
                                                    ->label('Copy from Excerpt')
                                                    ->icon('heroicon-o-clipboard')
                                                    ->action(function (Forms\Set $set, Get $get) {
                                                        $set('meta_description', $get('excerpt'));
                                                    })
                                            ),

                                        Forms\Components\TextInput::make('canonical_url')
                                            ->url()
                                            ->maxLength(255)
                                            ->helperText('Specify if this page is a duplicate of another URL'),

                                        Forms\Components\TagsInput::make('meta_keywords')
                                            ->helperText('Press Enter after each keyword (optional, less important for modern SEO)'),

                                        Forms\Components\Select::make('meta_robots')
                                            ->options([
                                                'index,follow' => 'Index, Follow (Default)',
                                                'noindex,follow' => 'No Index, Follow',
                                                'index,nofollow' => 'Index, No Follow',
                                                'noindex,nofollow' => 'No Index, No Follow',
                                            ])
                                            ->default('index,follow')
                                            ->helperText('Control how search engines crawl this page'),
                                    ])->columns(1),

                                Forms\Components\Section::make('Open Graph (Facebook, WhatsApp, LinkedIn)')
                                    ->description('How your page appears when shared on social media')
                                    ->collapsed()
                                    ->schema([
                                        Forms\Components\TextInput::make('og_title')
                                            ->maxLength(95)
                                            ->helperText('Leave blank to use meta title')
                                            ->hintAction(
                                                Forms\Components\Actions\Action::make('copyFromMetaTitle')
                                                    ->label('Copy from Meta Title')
                                                    ->icon('heroicon-o-clipboard')
                                                    ->action(function (Forms\Set $set, Get $get) {
                                                        $set('og_title', $get('meta_title') ?: $get('title'));
                                                    })
                                            ),

                                        Forms\Components\Textarea::make('og_description')
                                            ->rows(3)
                                            ->maxLength(200)
                                            ->helperText('Leave blank to use meta description')
                                            ->hintAction(
                                                Forms\Components\Actions\Action::make('copyFromMetaDesc')
                                                    ->label('Copy from Meta Description')
                                                    ->icon('heroicon-o-clipboard')
                                                    ->action(function (Forms\Set $set, Get $get) {
                                                        $set('og_description', $get('meta_description') ?: $get('excerpt'));
                                                    })
                                            ),

                                        Forms\Components\FileUpload::make('og_image')
                                            ->image()
                                            ->directory('pages/og-images')
                                            ->maxSize(2048)
                                            ->helperText('Recommended size: 1200x630px (will use featured image if left blank)'),

                                        Forms\Components\Select::make('og_type')
                                            ->options([
                                                'website' => 'Website',
                                                'article' => 'Article',
                                                'profile' => 'Profile',
                                            ])
                                            ->default('website'),
                                    ])->columns(1),

                                Forms\Components\Section::make('Twitter Card')
                                    ->description('Optimize appearance on X (Twitter)')
                                    ->collapsed()
                                    ->schema([
                                        Forms\Components\TextInput::make('twitter_title')
                                            ->maxLength(70)
                                            ->helperText('Leave blank to use meta title')
                                            ->hintAction(
                                                Forms\Components\Actions\Action::make('copyFromMetaTitle')
                                                    ->label('Copy from Meta Title')
                                                    ->icon('heroicon-o-clipboard')
                                                    ->action(function (Forms\Set $set, Get $get) {
                                                        $set('twitter_title', $get('meta_title') ?: $get('title'));
                                                    })
                                            ),

                                        Forms\Components\Textarea::make('twitter_description')
                                            ->rows(3)
                                            ->maxLength(200)
                                            ->helperText('Leave blank to use meta description')
                                            ->hintAction(
                                                Forms\Components\Actions\Action::make('copyFromMetaDesc')
                                                    ->label('Copy from Meta Description')
                                                    ->icon('heroicon-o-clipboard')
                                                    ->action(function (Forms\Set $set, Get $get) {
                                                        $set('twitter_description', $get('meta_description') ?: $get('excerpt'));
                                                    })
                                            ),

                                        Forms\Components\FileUpload::make('twitter_image')
                                            ->image()
                                            ->directory('pages/twitter-images')
                                            ->maxSize(2048)
                                            ->helperText('Recommended size: 1200x628px (will use OG image or featured image if left blank)'),

                                        Forms\Components\Select::make('twitter_card')
                                            ->options([
                                                'summary' => 'Summary',
                                                'summary_large_image' => 'Summary Large Image',
                                            ])
                                            ->default('summary_large_image'),
                                    ])->columns(1),
                            ]),

                        // Settings Tab
                        Forms\Components\Tabs\Tab::make('Settings')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Forms\Components\Section::make('Page Status')
                                    ->schema([
                                        Forms\Components\Select::make('status')
                                            ->options([
                                                'draft' => 'Draft',
                                                'published' => 'Published',
                                                'scheduled' => 'Scheduled',
                                            ])
                                            ->default('draft')
                                            ->required()
                                            ->live(),

                                        Forms\Components\DateTimePicker::make('published_at')
                                            ->label('Publish Date & Time')
                                            ->visible(fn (Get $get) => in_array($get('status'), ['published', 'scheduled']))
                                            ->helperText('Leave blank to publish immediately'),
                                    ])->columns(2),

                                Forms\Components\Section::make('Page Structure')
                                    ->schema([
                                        Forms\Components\Select::make('parent_id')
                                            ->label('Parent Page')
                                            ->relationship('parent', 'title')
                                            ->searchable()
                                            ->helperText('Create a page hierarchy'),

                                        Forms\Components\TextInput::make('order')
                                            ->numeric()
                                            ->default(0)
                                            ->helperText('Order of appearance (lower numbers appear first)'),

                                        Forms\Components\Select::make('template')
                                            ->options([
                                                'default' => 'Default',
                                                'full-width' => 'Full Width',
                                                'sidebar-left' => 'Sidebar Left',
                                                'sidebar-right' => 'Sidebar Right',
                                                'landing' => 'Landing Page',
                                            ])
                                            ->default('default')
                                            ->helperText('Page layout template'),
                                    ])->columns(2),
                            ]),

                        // Advanced Tab
                        Forms\Components\Tabs\Tab::make('Advanced')
                            ->icon('heroicon-o-code-bracket')
                            ->schema([
                                Forms\Components\Section::make('Custom Code')
                                    ->description('Add custom CSS and JavaScript for this page')
                                    ->collapsed()
                                    ->schema([
                                        Forms\Components\Textarea::make('custom_css')
                                            ->rows(5)
                                            ->helperText('Custom CSS (without <style> tags)'),

                                        Forms\Components\Textarea::make('custom_js')
                                            ->rows(5)
                                            ->helperText('Custom JavaScript (without <script> tags)'),
                                    ])->columns(1),

                                Forms\Components\Section::make('Schema Markup')
                                    ->description('Structured data for rich search results')
                                    ->collapsed()
                                    ->schema([
                                        Forms\Components\Textarea::make('schema_markup')
                                            ->rows(10)
                                            ->helperText('JSON-LD schema markup (will be automatically wrapped in <script> tags)')
                                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state, JSON_PRETTY_PRINT) : $state)
                                            ->dehydrateStateUsing(fn ($state) => json_decode($state, true)),
                                    ])->columns(1),

                                Forms\Components\Section::make('Custom Fields')
                                    ->description('Add custom metadata for this page')
                                    ->collapsed()
                                    ->schema([
                                        Forms\Components\KeyValue::make('custom_fields')
                                            ->keyLabel('Field Name')
                                            ->valueLabel('Field Value')
                                            ->addActionLabel('Add Custom Field'),
                                    ])->columns(1),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Page $record): string => $record->slug)
                    ->limit(50),

                Tables\Columns\ImageColumn::make('featured_image')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png')),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'draft',
                        'success' => 'published',
                        'warning' => 'scheduled',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('parent.title')
                    ->label('Parent')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Created By')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'scheduled' => 'Scheduled',
                    ]),

                Tables\Filters\SelectFilter::make('template')
                    ->options([
                        'default' => 'Default',
                        'full-width' => 'Full Width',
                        'sidebar-left' => 'Sidebar Left',
                        'sidebar-right' => 'Sidebar Right',
                        'landing' => 'Landing Page',
                    ]),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    // Tables\Actions\Action::make('preview')
                    //     ->icon('heroicon-o-eye')
                    //     ->url(fn (Page $record): string => route('pages.show', $record))
                    //     ->openUrlInNewTab(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    
                    Tables\Actions\BulkAction::make('publish')
                        ->icon('heroicon-o-check-circle')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['status' => 'published']))
                        ->deselectRecordsAfterCompletion(),
                        
                    Tables\Actions\BulkAction::make('draft')
                        ->icon('heroicon-o-pencil')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['status' => 'draft']))
                        ->deselectRecordsAfterCompletion(),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                \Illuminate\Database\Eloquent\SoftDeletingScope::class,
            ]);
    }
}