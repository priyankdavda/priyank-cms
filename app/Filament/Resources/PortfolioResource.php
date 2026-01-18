<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioResource\Pages;
use App\Models\Portfolio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 2;

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
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => 
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                            ),
                        
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Auto-generated from title, but you can customize it.'),
                        
                        Forms\Components\Textarea::make('short_description')
                            ->required()
                            ->maxLength(500)
                            ->rows(3)
                            ->helperText('Brief description shown on portfolio cards.'),
                        
                        Forms\Components\RichEditor::make('full_description')
                            ->required()
                            ->columnSpanFull()
                            ->helperText('Detailed description of the project.'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Client & Service Information')
                    ->schema([
                        Forms\Components\TextInput::make('client_name')
                            ->required()
                            ->maxLength(255)
                            ->helperText('e.g., Aivora'),
                        
                        Forms\Components\TagsInput::make('services')
                            ->required()
                            ->placeholder('Add service tags')
                            ->helperText('e.g., Data Processing, AI Solutions, Web Development')
                            ->suggestions([
                                'Data Processing',
                                'AI Solutions',
                                'Web Development',
                                'Mobile App Development',
                                'AI-driven SEO & AEO',
                                'Lead Generation',
                                'Brand & Social Management',
                                'Digital Marketing',
                            ]),
                        
                        Forms\Components\TagsInput::make('countries')
                            ->required()
                            ->placeholder('Add countries')
                            ->helperText('e.g., Germany, USA, UK')
                            ->suggestions([
                                'USA',
                                'Germany',
                                'UK',
                                'Canada',
                                'Australia',
                                'India',
                                'Singapore',
                            ]),
                        
                        Forms\Components\TextInput::make('location')
                            ->maxLength(255)
                            ->helperText('Specific location, e.g., "New York, USA"'),
                        
                        Forms\Components\DatePicker::make('completion_date')
                            ->helperText('Project completion date'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Project Requirements')
                    ->schema([
                        Forms\Components\Repeater::make('requirements')
                            ->schema([
                                Forms\Components\TextInput::make('requirement')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., Intelligent Process Automation'),
                            ])
                            ->columnSpanFull()
                            ->defaultItems(0)
                            ->addActionLabel('Add Requirement')
                            ->helperText('List key project requirements or features'),
                    ]),

                Forms\Components\Section::make('Solution & Results')
                    ->schema([
                        Forms\Components\RichEditor::make('solution_description')
                            ->columnSpanFull()
                            ->helperText('Describe the solution provided and the results achieved'),
                    ]),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('featured_image')
                            ->image()
                            ->directory('portfolio/featured')
                            ->maxSize(5120)
                            ->helperText('Main image for the portfolio item'),
                        
                        Forms\Components\FileUpload::make('gallery_images')
                            ->image()
                            ->multiple()
                            ->directory('portfolio/gallery')
                            ->maxSize(5120)
                            ->maxFiles(10)
                            ->reorderable()
                            ->helperText('Additional project screenshots or images'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->maxLength(255)
                            ->helperText('Leave blank to use the portfolio title'),
                        
                        Forms\Components\Textarea::make('meta_description')
                            ->maxLength(300)
                            ->rows(3)
                            ->helperText('Leave blank to use the short description'),
                        
                        Forms\Components\TagsInput::make('meta_keywords')
                            ->separator(','),
                    ])
                    ->columns(1)
                    ->collapsed(),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->default(true)
                            ->helperText('Publish this portfolio item'),
                        
                        Forms\Components\TextInput::make('display_order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Image')
                    ->circular(),
                
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                
                Tables\Columns\TextColumn::make('client_name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('services')
                    ->badge()
                    ->separator(',')
                    ->color('success'),
                
                Tables\Columns\TextColumn::make('countries')
                    ->badge()
                    ->separator(',')
                    ->color('info'),
                
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('display_order')
                    ->label('Order')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('display_order', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->trueLabel('Published only')
                    ->falseLabel('Draft only')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPortfolios::route('/'),
            'create' => Pages\CreatePortfolio::route('/create'),
            'edit' => Pages\EditPortfolio::route('/{record}/edit'),
        ];
    }
}