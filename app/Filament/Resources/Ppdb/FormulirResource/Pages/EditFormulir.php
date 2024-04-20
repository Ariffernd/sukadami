<?php

namespace App\Filament\Resources\Ppdb\FormulirResource\Pages;

use App\Filament\Resources\Ppdb\FormulirResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFormulir extends EditRecord
{
    protected static string $resource = FormulirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
