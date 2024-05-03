<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Spatie\Permission\Traits\HasRoles;

class FormulirPdb extends Page
{
    use HasRoles,HasPageShield;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.formulir-pdb';

}
