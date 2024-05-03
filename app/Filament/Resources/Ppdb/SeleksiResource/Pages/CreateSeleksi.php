<?php

namespace App\Filament\Resources\Ppdb\SeleksiResource\Pages;

use App\Filament\Resources\Ppdb\SeleksiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSeleksi extends CreateRecord
{
    protected static string $resource = SeleksiResource::class;

    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
