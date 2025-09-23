<?php

namespace App\Filament\Resources\EmailSettings;

use App\Filament\Resources\EmailSettings\Pages\CreateEmailSetting;
use App\Filament\Resources\EmailSettings\Pages\EditEmailSetting;
use App\Filament\Resources\EmailSettings\Pages\ListEmailSettings;
use App\Filament\Resources\EmailSettings\Schemas\EmailSettingForm;
use App\Filament\Resources\EmailSettings\Tables\EmailSettingsTable;
use App\Models\EmailSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EmailSettingResource extends Resource
{
    protected static ?string $model = EmailSetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): ?string
    {
        return 'System Setting';
    }

    public static function form(Schema $schema): Schema
    {
        return EmailSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmailSettingsTable::configure($table);
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
            'index' => ListEmailSettings::route('/'),
            'create' => CreateEmailSetting::route('/create'),
            'edit' => EditEmailSetting::route('/{record}/edit'),
        ];
    }
}
