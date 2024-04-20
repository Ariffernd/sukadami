<?php

namespace App\Filament\Resources\Ppdb;

use Filament\Forms;
use Filament\Tables;
use App\Models\Periode;
use App\Models\Formulir;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Ppdb\FormulirResource\Pages;
use Filament\Infolists\Components\Section as ComponentsSection;
use App\Filament\Resources\Ppdb\FormulirResource\RelationManagers;

class FormulirResource extends Resource
{
    protected static ?string $model = Formulir::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'PPDB';
    protected static ?string $navigationLabel = 'Formulir PPDB';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make('user_id')
                        ->hidden(),
                    Select::make('periode_id')
                        ->label('Tahun Ajaran')
                        ->placeholder('Tentukan Tahun Ajaran yang Tersedia. Jika tidak ada, maka Penerimaan Peserta Didik Baru (PPDB) sedang tutup.')
                        ->options(Periode::where('status', true)->pluck(DB::raw("CONCAT(ta, ' - ', gel)"), 'id')->toArray())
                        ->required()
                        ->searchable(),
                ]),

                    Section::make('Data Siswa')->schema([
                        TextInput::make('nama')
                        ->required()
                        ->label('Nama Lengkap'),
                        TextInput::make('nama_p')
                        ->label('Nama Panggilan'),
                       

                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFormulirs::route('/'),
            'create' => Pages\CreateFormulir::route('/create'),
            'edit' => Pages\EditFormulir::route('/{record}/edit'),
        ];
    }
}
