<?php

namespace App\Filament\Resources\PartnerResource\Pages;

use App\Filament\Resources\PartnerResource;
use App\Models\Partner;
use App\Models\Service;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;


class ListPartners extends ListRecords
{
    protected static string $resource = PartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $data = [];

        // Tab "All"
        $data['All'] = Tab::make('All');

        $services = Partner::select('service_id')
            ->distinct()
            ->with('service') // Pastikan relasi service dimuat
            ->get();
        foreach ($services as $client) {
            if ($client->service) { // Pastikan service tidak null
                $data[$client->service->sort_name] = Tab::make($client->service->sort_name)
                    ->query(fn(Builder $query) => $query->where('service_id', $client->service_id));
            }
        }

        return $data;
    }
}
