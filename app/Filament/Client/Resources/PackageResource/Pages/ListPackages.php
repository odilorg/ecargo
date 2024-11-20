<?php

namespace App\Filament\Client\Resources\PackageResource\Pages;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Client\Resources\PackageResource;

class ListPackages extends ListRecords
{
    protected static string $resource = PackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Ожидаемые (' . $this->getStatusCount('waiting') . ')' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'waiting')),
            'На складе (' . $this->getStatusCount('arrived') . ')' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'arrived')),
            'На упаковке (' . $this->getStatusCount('packing') . ')' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'packing')),
            'Отправленные (' . $this->getStatusCount('sent') . ')' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'sent')),        
        ];
    }
    
    /**
     * Get the count of items for a specific status.
     *
     * @param string $status
     * @return int
     */
    protected function getStatusCount(string $status): int
    {
        return \App\Models\Package::where('status', $status)->count();
    }
}
