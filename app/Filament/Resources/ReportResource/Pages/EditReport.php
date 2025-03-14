<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Filament\Pages\Actions\Action;

class EditReport extends EditRecord
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }


    protected function getFormActions(): array
    {
        $user = Auth::user();
        $isMember = $user->roles()->where('name', 'member')->exists();
        if ($isMember) {
            return [];
        } else {
            return parent::getFormActions();
        }
    }
}
