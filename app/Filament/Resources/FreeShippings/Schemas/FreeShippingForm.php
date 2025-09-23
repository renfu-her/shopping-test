<?php

namespace App\Filament\Resources\FreeShippings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FreeShippingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Free Shipping Rule')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('start_date')
                                    ->label('Start Date')
                                    ->required()
                                    ->helperText('When the free shipping rule becomes active'),

                                DatePicker::make('end_date')
                                    ->label('End Date')
                                    ->required()
                                    ->helperText('When the free shipping rule expires'),
                            ]),

                        TextInput::make('minimum_amount')
                            ->label('Minimum Order Amount')
                            ->numeric()
                            ->prefix('$')
                            ->required()
                            ->helperText('Minimum order amount required for free shipping'),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Only active rules will be applied'),
                    ]),
            ]);
    }
}
