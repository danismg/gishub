<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Models\Client;
use App\Models\Service;
use Filament\Actions;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords;

use Filament\Resources\Components\Tab;

class ListClients extends ListRecords
{
    protected static string $resource = ClientResource::class;

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

        $services = Client::select('service_id')
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
