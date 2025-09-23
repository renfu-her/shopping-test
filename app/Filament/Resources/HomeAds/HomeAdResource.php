<?php

namespace App\Filament\Resources\HomeAds;

use App\Filament\Resources\HomeAds\Pages\CreateHomeAd;
use App\Filament\Resources\HomeAds\Pages\EditHomeAd;
use App\Filament\Resources\HomeAds\Pages\ListHomeAds;
use App\Filament\Resources\HomeAds\Schemas\HomeAdForm;
use App\Filament\Resources\HomeAds\Tables\HomeAdsTable;
use App\Models\HomeAd;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HomeAdResource extends Resource
{
    protected static ?string $model = HomeAd::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return HomeAdForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HomeAdsTable::configure($table);
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
            'index' => ListHomeAds::route('/'),
            'create' => CreateHomeAd::route('/create'),
            'edit' => EditHomeAd::route('/{record}/edit'),
        ];
    }
}
