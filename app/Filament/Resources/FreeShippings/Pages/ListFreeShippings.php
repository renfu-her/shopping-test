<?php

namespace App\Filament\Resources\FreeShippings\Pages;

use App\Filament\Resources\FreeShippings\FreeShippingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFreeShippings extends ListRecords
{
    protected static string $resource = FreeShippingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
