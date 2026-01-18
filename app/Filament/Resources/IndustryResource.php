<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IndustryResource\Pages;
use App\Models\Industry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Get;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class IndustryResource extends Resource
{
    protected static ?string $model = Industry::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Industries';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\FileUpload::make('icon_image')
                    ->label('Icon Image (PNG/JPG/WebP)')
                    ->image()
                    ->directory('industries/icons')
                    ->visibility('public'),

                    Forms\Components\Textarea::make('icon_svg')
                    ->label('SVG Icon (Paste SVG code)')
                    ->rows(6)
                    ->reactive(),
                
                Placeholder::make('svg_preview')
                    ->label('SVG Preview')
                    ->content(function (Get $get) {
                        $svg = $get('icon_svg');
                
                        if (! $svg) {
                            return new HtmlString(
                                '<span class="text-gray-400">Paste SVG code to see preview</span>'
                            );
                        }
                
                        // Basic safety (recommended)
                        $svg = Str::of($svg)->replaceMatches(
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
                    ->sortable()
                    ->searchable(),

                Tables\Columns\ImageColumn::make('icon_image')
                    ->circular()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->since(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
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
            'index' => Pages\ListIndustries::route('/'),
            'create' => Pages\CreateIndustry::route('/create'),
            'edit' => Pages\EditIndustry::route('/{record}/edit'),
        ];
    }
}
