<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use App\Models\Partner;
use App\Models\Report;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Components\Tab;
use Google\Service\CloudSourceRepositories\Repo;
use Illuminate\Support\Facades\DB;


class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        $data = [];
        $data['All'] = Tab::make("All (" . Report::count() . ")")
            ->modifyQueryUsing(fn(Builder $query) => $query);

        $services = Report::select('service_id', DB::raw('COUNT(*) as total'))
            ->groupBy('service_id')
            ->with('service')
            ->get();

        foreach ($services as $service) {
            if ($service->service) {
                $data[$service->service->sort_name] = Tab::make("{$service->service->sort_name} ({$service->total})")
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('service_id', $service->service_id));
            }
        }

        return $data;
    }
}
