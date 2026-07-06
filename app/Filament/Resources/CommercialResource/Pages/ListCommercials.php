<?php

namespace App\Filament\Resources\CommercialResource\Pages;

use App\Filament\Resources\CommercialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCommercials extends ListRecords
{
    protected static string $resource = CommercialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
