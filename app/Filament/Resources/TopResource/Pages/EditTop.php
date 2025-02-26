<?php

namespace App\Filament\Resources\TopResource\Pages;

use App\Filament\Resources\TopResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTop extends EditRecord
{
    protected static string $resource = TopResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
