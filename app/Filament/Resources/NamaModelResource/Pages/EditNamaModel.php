<?php

namespace App\Filament\Resources\NamaModelResource\Pages;

use App\Filament\Resources\NamaModelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNamaModel extends EditRecord
{
    protected static string $resource = NamaModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
