<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Activity Information')
                    ->schema([
                        TextInput::make('title')
                            ->label('Activity Title')
                            ->required()
                            ->maxLength(255)
                            ->helperText('The main title of the activity'),

                        TextInput::make('subtitle')
                            ->label('Subtitle')
                            ->maxLength(255)
                            ->helperText('Optional subtitle for the activity'),

                        RichEditor::make('content')
                            ->label('Content')
                            ->required()
                            ->columnSpanFull()
                            ->helperText('Detailed description of the activity'),

                        FileUpload::make('image')
                            ->label('Activity Image')
                            ->image()
                            ->imageEditor()
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('675')
                            ->directory('activities')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Recommended size: 1200x675px'),

                        Grid::make(3)
                            ->schema([
                                DatePicker::make('date')
                                    ->label('Activity Date')
                                    ->required()
                                    ->helperText('When the activity takes place'),

                                TextInput::make('sort_order')
                                    ->label('Sort Order')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Lower numbers appear first'),

                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true)
                                    ->helperText('Only active activities will be displayed'),
                            ]),
                    ]),
            ]);
    }
}
