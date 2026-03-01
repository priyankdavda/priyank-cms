<?php
// app/Filament/Resources/AchievementResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\AchievementResource\Pages;
use App\Models\Achievement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class AchievementResource extends Resource
{
    protected static ?string $model = Achievement::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Achievements';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\TextInput::make('title')
                ->label('Stat Value')
                ->placeholder('e.g. 98% or 20+ or Top 10')
                ->required()
                ->maxLength(100),

            Forms\Components\TextInput::make('subtitle')
                ->label('Stat Label')
                ->placeholder('e.g. Client Retention Rate')
                ->required()
                ->maxLength(255),

            Forms\Components\FileUpload::make('icon_image')
                ->label('Icon Image')
                ->image()
                ->directory('achievements/icons')
                ->reactive(),

            Forms\Components\Textarea::make('icon_svg')
                ->label('SVG Icon')
                ->rows(6)
                ->reactive(),

            // SVG / Image Preview
            Forms\Components\Placeholder::make('icon_preview')
                ->label('Icon Preview')
                ->content(function (Get $get) {
                    if ($get('icon_image')) {
                        return new HtmlString(
                            "<div class='flex justify-center items-center p-4 rounded-lg bg-gray-900'>
                                <img src='".asset('storage/'.$get('icon_image'))."' class='w-16 h-16 mx-auto object-contain' />
                            </div>"
                        );
                    }

                    if (! $get('icon_svg')) {
                        return new HtmlString(
                            "<span class='text-gray-400 text-sm'>Upload an image or paste SVG to see a preview</span>"
                        );
                    }

                    $svg = Str::of($get('icon_svg'))->replaceMatches(
                        '/<script.*?>.*?<\/script>/is',
                        ''
                    );

                    return new HtmlString("
                        <div class='flex justify-center items-center p-4 rounded-lg bg-gray-900'>
                            <div class='w-16 h-16 text-white'>
                                {$svg}
                            </div>
                        </div>
                    ");
                })
                ->columnSpanFull(),

            Forms\Components\Toggle::make('is_active')
                ->label('Active')
                ->default(true),

            Forms\Components\TextInput::make('sort_order')
                ->label('Sort Order')
                ->numeric()
                ->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                // SVG / image thumbnail
                Tables\Columns\ImageColumn::make('icon_image')
                    ->label('Icon')
                    ->defaultImageUrl(asset('images/placeholder-icon.png'))
                    ->size(40),

                Tables\Columns\TextColumn::make('title')
                    ->label('Stat Value')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Stat Label')
                    ->searchable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->sortable(),
            ])
            ->reorderable('sort_order')  // drag-to-reorder rows
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

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAchievements::route('/'),
            'create' => Pages\CreateAchievement::route('/create'),
            'edit'   => Pages\EditAchievement::route('/{record}/edit'),
        ];
    }
}