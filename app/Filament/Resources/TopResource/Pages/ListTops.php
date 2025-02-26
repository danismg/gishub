<?php

namespace App\Filament\Resources\TopResource\Pages;

use App\Filament\Resources\TopResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTops extends ListRecords
{
    protected static string $resource = TopResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
