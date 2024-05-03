<?php

namespace App\Filament\Resources\Ppdb\SeleksiResource\Pages;

use App\Filament\Resources\Ppdb\SeleksiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeleksis extends ListRecords
{
    protected static string $resource = SeleksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
