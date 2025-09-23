<?php

namespace App\Filament\Resources\FreeShippings;

use App\Filament\Resources\FreeShippings\Pages\CreateFreeShipping;
use App\Filament\Resources\FreeShippings\Pages\EditFreeShipping;
use App\Filament\Resources\FreeShippings\Pages\ListFreeShippings;
use App\Filament\Resources\FreeShippings\Schemas\FreeShippingForm;
use App\Filament\Resources\FreeShippings\Tables\FreeShippingsTable;
use App\Models\FreeShipping;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FreeShippingResource extends Resource
{
    protected static ?string $model = FreeShipping::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'minimum_amount';

    public static function form(Schema $schema): Schema
    {
        return FreeShippingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FreeShippingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFreeShippings::route('/'),
            'create' => CreateFreeShipping::route('/create'),
            'edit' => EditFreeShipping::route('/{record}/edit'),
        ];
    }
}
