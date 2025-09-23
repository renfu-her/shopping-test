<?php

namespace App\Filament\Resources\Adverts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AdvertForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Advertisement Information')
                    ->schema([
                        TextInput::make('title')
                            ->label('Ad Title')
                            ->required()
                            ->maxLength(255)
                            ->helperText('The title of the advertisement'),

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Brief description of the advertisement'),

                        TextInput::make('url')
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
                            ->directory('adverts')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Recommended size: 1200x675px'),

                        FileUpload::make('image_thumb')
                            ->label('Thumbnail Image')
                            ->image()
                            ->imageEditor()
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('300')
                            ->imageResizeTargetHeight('300')
                            ->directory('adverts/thumbnails')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Optional thumbnail image (300x300px)'),

                        Grid::make(3)
                            ->schema([
                                DatePicker::make('start_date')
                                    ->label('Start Date')
                                    ->required()
                                    ->helperText('When the ad should start showing'),

                                DatePicker::make('end_date')
                                    ->label('End Date')
                                    ->required()
                                    ->helperText('When the ad should stop showing'),

                                TextInput::make('sort_order')
                                    ->label('Sort Order')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Lower numbers appear first'),
                            ]),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Only active ads will be displayed'),
                    ]),
            ]);
    }
}
