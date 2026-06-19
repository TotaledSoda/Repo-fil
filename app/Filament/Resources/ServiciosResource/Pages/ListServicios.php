<?php

namespace App\Filament\Resources\ServiciosResource\Pages;

use App\Filament\Resources\ServiciosResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServicios extends ListRecords
{
    protected static string $resource = ServiciosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
