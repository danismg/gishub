<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use App\Imports\ImportAssets;
use App\Models\Asset;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\Category;
use Illuminate\Support\Facades\DB;


class ListAssets extends ListRecords
{
    protected static string $resource = AssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getHeader(): ?View
    {
        $data = CreateAction::make();
        return view('filament.custom.asset', compact('data'));
    }
    public $file = '';

    public function save()
    {
        if ($this->file != '') {
            Excel::import(new ImportAssets, $this->file);
        }
    }

    public function getTabs(): array
    {
        $data = [];
        $data['All'] = Tab::make("All (" . Asset::count() . ")")
            ->modifyQueryUsing(fn(Builder $query) => $query);
        $categories = Asset::select('category', DB::raw('COUNT(*) as total'))
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        foreach ($categories as $cat) {
            $data[$cat->category] = Tab::make("{$cat->category} ({$cat->total})")
                ->modifyQueryUsing(fn(Builder $query) => $query->where('category', $cat->category));
        }

        return $data;
    }
}
