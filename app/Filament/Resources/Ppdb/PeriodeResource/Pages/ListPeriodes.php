<?php

namespace App\Filament\Resources\Ppdb\PeriodeResource\Pages;

use App\Filament\Resources\Ppdb\PeriodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeriodes extends ListRecords
{
    protected static string $resource = PeriodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
