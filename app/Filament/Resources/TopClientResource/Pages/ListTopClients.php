<?php

namespace App\Filament\Resources\TopClientResource\Pages;

use App\Filament\Resources\TopClientResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTopClients extends ListRecords
{
    protected static string $resource = TopClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
