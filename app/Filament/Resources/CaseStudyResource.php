<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CaseStudyResource\Pages;
use App\Models\CaseStudy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Filament\Forms\Get;

class CaseStudyResource extends Resource
{
    protected static ?string $model = CaseStudy::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationGroup = 'Content';
    
    protected static ?int $navigationSort = 2;
    
    protected static ?string $recordTitleAttribute = 'title';

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
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->columnSpanFull(),
                            
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->rules(['alpha_dash'])
                            ->columnSpanFull(),
                            
                        Forms\Components\Textarea::make('subheading')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Classification')
                    ->schema([
                        Forms\Components\TextInput::make('category')
                            ->maxLength(255)
                            ->placeholder('e.g., Insurance, Healthcare'),
                            
                        Forms\Components\TextInput::make('industry')
                            ->maxLength(255)
                            ->placeholder('e.g., Insurance'),
                            
                        Forms\Components\TextInput::make('country')
                            ->maxLength(255)
                            ->placeholder('e.g., India'),
                            
                        Forms\Components\TextInput::make('service')
                            ->maxLength(255)
                            ->placeholder('e.g., Web Development'),
                            
                        Forms\Components\DatePicker::make('completed_date')
                            ->native(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Case Study Details')
                    ->schema([
                        Forms\Components\TagsInput::make('keywords')
                            ->placeholder('Add keywords')
                            ->suggestions([
                                'Car insurance',
                                'Student health insurance',
                                'Auto insurance',
                                'SEO',
                                'Digital Marketing',
                            ])
                            ->columnSpanFull(),
                            
                        Forms\Components\Textarea::make('challenge')
                            ->rows(5)
                            ->placeholder('Describe the challenges faced...')
                            ->columnSpanFull(),
                            
                        Forms\Components\Textarea::make('results')
                            ->rows(5)
                            ->placeholder('Describe the results achieved...')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Media')
                    ->schema([
                                                    
                        Forms\Components\FileUpload::make('featured_image')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->directory('case-studies/featured')
                            ->maxSize(2048)
                            ->columnSpanFull(),
                        
                        Forms\Components\FileUpload::make('gallery')
                            ->multiple()
                            ->image()
                            ->maxSize(2048)
                            ->maxFiles(10)
                            ->directory('case-studies/gallery')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

              
                Forms\Components\Section::make('Content')
                    ->schema([
                        Forms\Components\RichEditor::make('content')
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->fileAttachmentsDirectory('case-studies/attachments')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('SEO Meta')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->maxLength(60)
                            ->placeholder('Leave empty to use title')
                            ->helperText('Recommended: 50-60 characters')
                            ->columnSpanFull(),
                            
                        Forms\Components\Textarea::make('meta_description')
                            ->rows(3)
                            ->maxLength(160)
                            ->helperText('Recommended: 150-160 characters')
                            ->columnSpanFull(),
                            
                        Forms\Components\Textarea::make('meta_keywords')
                            ->rows(2)
                            ->placeholder('keyword1, keyword2, keyword3')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Forms\Components\Section::make('Publishing')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->label('Published')
                            ->default(false)
                            ->inline(false),
                            
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured')
                            ->default(false)
                            ->inline(false),
                            
                        Forms\Components\DateTimePicker::make('published_at')
                            ->native(false)
                            ->seconds(false),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png')),
                    
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->weight('medium'),
                    
                Tables\Columns\TextColumn::make('category')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                    
                Tables\Columns\TextColumn::make('industry')
                    ->searchable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('country')
                    ->searchable()
                    ->toggleable(),
                    
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published')
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('views')
                    ->sortable()
                    ->toggleable()
                    ->numeric(),
                    
                Tables\Columns\TextColumn::make('completed_date')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->multiple()
                    ->searchable(),
                    
                Tables\Filters\SelectFilter::make('industry')
                    ->multiple()
                    ->searchable(),
                    
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->trueLabel('Published only')
                    ->falseLabel('Draft only')
                    ->native(false),
                    
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueLabel('Featured only')
                    ->falseLabel('Not featured')
                    ->native(false),
                    
                Tables\Filters\Filter::make('completed_date')
                    ->form([
                        Forms\Components\DatePicker::make('completed_from')
                            ->native(false),
                        Forms\Components\DatePicker::make('completed_until')
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['completed_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('completed_date', '>=', $date),
                            )
                            ->when(
                                $data['completed_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('completed_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('toggle_publish')
                    ->label(fn (CaseStudy $record) => $record->is_published ? 'Unpublish' : 'Publish')
                    ->icon(fn (CaseStudy $record) => $record->is_published ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->color(fn (CaseStudy $record) => $record->is_published ? 'warning' : 'success')
                    ->action(function (CaseStudy $record) {
                        if ($record->is_published) {
                            $record->unpublish();
                        } else {
                            $record->publish();
                        }
                    })
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each->publish();
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                        
                    Tables\Actions\BulkAction::make('unpublish')
                        ->label('Unpublish Selected')
                        ->icon('heroicon-o-eye-slash')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each->unpublish();
                        })
                        ->requiresConfirmation()
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
            'index' => Pages\ListCaseStudies::route('/'),
            'create' => Pages\CreateCaseStudy::route('/create'),
            'edit' => Pages\EditCaseStudy::route('/{record}/edit'),
            'view' => Pages\ViewCaseStudy::route('/{record}'),
        ];
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_published', true)->count();
    }
    
    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}