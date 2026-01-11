<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Banner Content')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Internal Title')
                                    ->helperText('For admin reference only')
                                    ->maxLength(255),
                                
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true)
                                    ->inline(false),
                            ]),

                        Forms\Components\FileUpload::make('background_image')
                            ->label('Background Image')
                            ->image()
                            ->imageEditor()
                            ->directory('banners')
                            ->maxSize(5120)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('heading')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('paragraph')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ]),

                Section::make('Button Configuration')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('button_text')
                                    ->label('Button Text')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('button_link')
                                    ->label('Button Link')
                                    ->url()
                                    ->maxLength(255),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('button_target')
                                    ->label('Link Target')
                                    ->options([
                                        '_self' => 'Same Window',
                                        '_blank' => 'New Tab',
                                    ])
                                    ->default('_self'),

                                Forms\Components\ColorPicker::make('button_color')
                                    ->label('Button Color')
                                    ->default('#000000'),
                            ]),
                    ]),

                Section::make('Styling & Layout')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('text_alignment')
                                    ->label('Text Alignment')
                                    ->options([
                                        'left' => 'Left',
                                        'center' => 'Center',
                                        'right' => 'Right',
                                    ])
                                    ->default('left'),

                                Forms\Components\ColorPicker::make('text_color')
                                    ->label('Text Color')
                                    ->default('#ffffff'),
                            ]),

                        Forms\Components\TextInput::make('order')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first'),
                    ]),

                Section::make('Schedule (Optional)')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\DateTimePicker::make('start_date')
                                    ->label('Start Date & Time')
                                    ->native(false),

                                Forms\Components\DateTimePicker::make('end_date')
                                    ->label('End Date & Time')
                                    ->native(false),
                            ]),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('background_image')
                    ->label('Image')
                    ->circular(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('heading')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->badge(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Start')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('End')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->reorderable('order');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}