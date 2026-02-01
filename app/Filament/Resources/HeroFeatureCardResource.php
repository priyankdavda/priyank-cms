<?php
namespace App\Filament\Resources;

use App\Filament\Resources\HeroFeatureCardResource\Pages;
use App\Models\HeroFeatureCard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class HeroFeatureCardResource extends Resource
{
    protected static ?string $model = HeroFeatureCard::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Hero Feature Cards';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->rows(4),

            Forms\Components\FileUpload::make('icon_image')
                ->label('Icon Image')
                ->image()
                ->directory('hero-feature-cards/icons')
                ->reactive(),

            Forms\Components\Textarea::make('icon_svg')
                ->label('SVG Icon')
                ->rows(6)
                ->reactive(),

            // 🔍 SVG Preview (no separate view)
            Forms\Components\Placeholder::make('svg_preview')
                ->label('Icon Preview')
                ->content(function (Get $get) {
                    // if ($get('icon_image')) {
                    //     return new HtmlString(
                    //         "<img src='".asset('storage/'.$get('icon_image'))."' class='w-16 h-16 mx-auto' />"
                    //     );
                    // }

                    if (! $get('icon_svg')) {
                        return new HtmlString(
                            "<span class='text-gray-400'>Upload an image or paste SVG to preview</span>"
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
                ->default(true),

            Forms\Components\TextInput::make('sort_order')
                ->numeric()
                ->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->since(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroFeatureCards::route('/'),
            'create' => Pages\CreateHeroFeatureCard::route('/create'),
            'edit' => Pages\EditHeroFeatureCard::route('/{record}/edit'),
        ];
    }
}
