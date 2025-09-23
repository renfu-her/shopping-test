<?php

namespace App\Filament\Resources\Faqs\Schemas;

use App\Models\FaqCategory;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('FAQ Information')
                    ->schema([
                        TextInput::make('title')
                            ->label('Question')
                            ->required()
                            ->maxLength(255)
                            ->helperText('The question that will be displayed'),

                        Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'title')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('title')->required(),
                            ]),

                        RichEditor::make('content')
                            ->label('Answer')
                            ->required()
                            ->columnSpanFull()
                            ->helperText('The detailed answer to the question'),

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
                                    ->helperText('Only active FAQs will be displayed'),
                            ]),
                    ]),
            ]);
    }
}
