<?php

namespace App\Filament\Resources\Ppdb\PeriodeResource\Pages;

use App\Filament\Resources\Ppdb\PeriodeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePeriode extends CreateRecord
{
    protected static string $resource = PeriodeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
