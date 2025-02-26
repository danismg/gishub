<?php

namespace App\Filament\Resources\NamaModelResource\Pages;

use App\Filament\Resources\NamaModelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNamaModels extends ListRecords
{
    protected static string $resource = NamaModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
