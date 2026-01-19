<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavigationItemResource\Pages;
use App\Models\NavigationItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NavigationItemResource extends Resource
{
    protected static ?string $model = NavigationItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationLabel = 'Navigation';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Navigation Item Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->maxLength(255)
                            ->helperText('Leave blank to auto-generate from title'),

                        Forms\Components\TextInput::make('url')
                            ->maxLength(255)
                            ->placeholder('/about-us or https://example.com')
                            ->helperText('Internal path (e.g., /about) or external URL (e.g., https://example.com)'),

                        Forms\Components\Select::make('parent_id')
                            ->label('Parent Menu Item')
                            ->relationship('parent', 'title', function (Builder $query, ?NavigationItem $record) {
                                // Exclude the current item and its descendants to prevent circular references
                                if ($record) {
                                    $excludeIds = [$record->id];
                                    $descendants = self::getDescendantIds($record);
                                    $excludeIds = array_merge($excludeIds, $descendants);
                                    $query->whereNotIn('id', $excludeIds);
                                }
                                return $query->orderBy('title');
                            })
                            ->searchable()
                            ->preload()
                            ->placeholder('Select parent (leave empty for root level)')
                            ->getOptionLabelFromRecordUsing(fn (NavigationItem $record) => $record->getFullPath())
                            ->helperText('Select a parent to create a nested menu item'),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0)
                                    ->required()
                                    ->helperText('Lower numbers appear first'),

                                Forms\Components\Select::make('target')
                                    ->options([
                                        '_self' => 'Same Window',
                                        '_blank' => 'New Window',
                                    ])
                                    ->default('_self')
                                    ->required(),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true)
                                    ->required(),
                            ]),

                        Forms\Components\TextInput::make('icon')
                            ->maxLength(255)
                            ->placeholder('heroicon-o-home')
                            ->helperText('Heroicon name (e.g., heroicon-o-home)'),

                        Forms\Components\TextInput::make('css_class')
                            ->label('CSS Class')
                            ->maxLength(255)
                            ->placeholder('custom-menu-class')
                            ->helperText('Additional CSS classes for styling'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function (NavigationItem $record) {
                        $indent = str_repeat('—', $record->getDepthLevel());
                        return $indent . ' ' . $record->title;
                    }),

                Tables\Columns\TextColumn::make('url')
                    ->searchable()
                    ->limit(40)
                    ->placeholder('No URL'),

                Tables\Columns\TextColumn::make('parent.title')
                    ->label('Parent')
                    ->searchable()
                    ->placeholder('Root Level')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All items')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),

                Tables\Filters\Filter::make('root_items')
                    ->label('Root Items Only')
                    ->query(fn (Builder $query) => $query->whereNull('parent_id')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                // Tables\Actions\Action::make('view_children')
                //     ->label('View Children')
                //     ->icon('heroicon-o-chevron-right')
                //     ->url(fn (NavigationItem $record) => NavigationItemResource::getUrl('index', [
                //         'tableFilters' => [
                //             'parent_id' => ['value' => $record->id]
                //         ]
                //     ]))
                //     ->visible(fn (NavigationItem $record) => $record->hasChildren()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->update(['is_active' => true]))
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn ($records) => $records->each->update(['is_active' => false]))
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation(),
                ]),
            ])
            ->reorderable('sort_order')
            ->groups([
                Tables\Grouping\Group::make('parent.title')
                    ->label('Parent')
                    ->getTitleFromRecordUsing(fn (NavigationItem $record) =>
                        $record->parent?->title ?? 'Root Level'
                    )
                    ->getKeyFromRecordUsing(fn (NavigationItem $record) =>
                        (string) ($record->parent_id ?? 0)
                    ),
            ])
            ->defaultGroup('parent.title');;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNavigationItems::route('/'),
            'create' => Pages\CreateNavigationItem::route('/create'),
            'edit' => Pages\EditNavigationItem::route('/{record}/edit'),
        ];
    }

    // Helper method to get all descendant IDs
    protected static function getDescendantIds(NavigationItem $item): array
    {
        $ids = [];
        $children = $item->children;

        foreach ($children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, self::getDescendantIds($child));
        }

        return $ids;
    }
}