<?php

namespace App\Filament\Resources\Ppdb\PeriodeResource\Pages;

use App\Filament\Resources\Ppdb\PeriodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPeriode extends ViewRecord
{
    protected static string $resource = PeriodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
