<?php

namespace App\Filament\Resources\TopClientResource\Pages;

use App\Filament\Resources\TopClientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTopClient extends EditRecord
{
    protected static string $resource = TopClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
