<?php

namespace App\Filament\Resources\Ppdb\SeleksiResource\Pages;

use App\Filament\Resources\Ppdb\SeleksiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeleksi extends EditRecord
{
    protected static string $resource = SeleksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
