<?php

namespace App\Filament\Resources\FreeShippings\Pages;

use App\Filament\Resources\FreeShippings\FreeShippingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFreeShipping extends EditRecord
{
    protected static string $resource = FreeShippingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
