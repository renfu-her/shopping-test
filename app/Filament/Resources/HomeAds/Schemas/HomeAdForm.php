<?php

namespace App\Filament\Resources\HomeAds\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class HomeAdForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Home Advertisement')
                    ->schema([
                        TextInput::make('title')
                            ->label('Ad Title')
                            ->required()
                            ->maxLength(255)
                            ->helperText('The title of the home page advertisement'),

                        TextInput::make('link')
                            ->label('Link URL')
                            ->url()
                            ->maxLength(255)
                            ->helperText('Where users will be redirected when they click the ad'),

                        FileUpload::make('image')
                            ->label('Ad Image')
                            ->image()
                            ->imageEditor()
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('675')
                            ->directory('home-ads')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Recommended size: 1200x675px'),

                        FileUpload::make('image_thumb')
                            ->label('Thumbnail Image')
                            ->image()
                            ->imageEditor()
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('300')
                            ->imageResizeTargetHeight('300')
                            ->directory('home-ads/thumbnails')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Optional thumbnail image (300x300px)'),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('sort_order')
                                    ->label('Sort Order')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Lower numbers appear first'),

                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true)
                                    ->helperText('Only active ads will be displayed'),
                            ]),
                    ]),
            ]);
    }
}
