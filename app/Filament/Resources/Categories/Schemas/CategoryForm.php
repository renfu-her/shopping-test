<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Category Name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, $set) {
                                if ($state) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->label('URL Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Auto-generated from category name'),
                    ]),

                Select::make('parent_id')
                    ->label('Parent Category')
                    ->options(function () {
                        return Category::with('ancestors')
                            ->orderBy('sort_order')
                            ->get()
                            ->mapWithKeys(function ($category) {
                                $indent = str_repeat('   ', $category->ancestors->count());
                                $prefix = $category->ancestors->count() > 0 ? '- ' : '';
                                return [$category->id => $indent . $prefix . $category->name];
                            });
                    })
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->placeholder('Select a parent category (optional)')
                    ->helperText('Leave empty for root category')
                    ->createOptionForm([
                        TextInput::make('name')->required(),
                        TextInput::make('slug')->required(),
                    ]),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->maxLength(500)
                    ->helperText('Optional description for the category'),

                TextInput::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Lower numbers appear first'),
            ]);
    }
}
