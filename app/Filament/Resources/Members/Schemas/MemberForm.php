<?php

namespace App\Filament\Resources\Members\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                            ]),

                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->maxLength(255),

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->minLength(8)
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(fn ($state) => bcrypt($state)),

                        Toggle::make('is_active')
                            ->label('Active Status')
                            ->default(true)
                            ->helperText('Inactive members cannot log in'),
                    ]),

                Section::make('Personal Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('gender')
                                    ->label('Gender')
                                    ->options([
                                        'male' => 'Male',
                                        'female' => 'Female',
                                        'other' => 'Other',
                                    ]),

                                DatePicker::make('birthday')
                                    ->label('Birthday')
                                    ->maxDate(now()),
                            ]),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('county')
                                    ->label('County')
                                    ->maxLength(255),

                                TextInput::make('district')
                                    ->label('District')
                                    ->maxLength(255),

                                TextInput::make('zipcode')
                                    ->label('Zip Code')
                                    ->maxLength(255),
                            ]),

                        TextInput::make('address')
                            ->label('Address')
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
