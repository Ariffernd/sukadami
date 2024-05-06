<?php

namespace App\Filament\Resources\Ppdb;

use Filament\Forms;
use Filament\Tables;
use App\Models\Periode;
use App\Models\Seleksi;
use Filament\Forms\Form;
use App\Models\SeleksiPd;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Ppdb\SeleksiResource\Pages;
use App\Filament\Resources\Ppdb\SeleksiResource\RelationManagers;

class SeleksiResource extends Resource
{
    protected static ?string $model = Seleksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';
    protected static ?string $navigationGroup = 'PPDB';
    protected static ?string $navigationLabel = 'Seleksi Peserta';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Select::make('ta')
                        ->label('Tahun Ajaran')
                        ->options(Periode::all()->pluck('ta', 'ta'))
                        ->searchable(),
                    Select::make('gel')
                        ->label('Gelombang')
                        ->options(Periode::all()->pluck('gel', 'gel')->unique())
                        ->searchable(),
                    DatePicker::make('tgl_sel')
                        ->label('Tanggal Seleksi')
                        ->required()
                        ->native(false)
                        ->displayFormat('d/m/Y'),
                    TextInput::make('ket')
                        ->label('Keterangan')
                ])->columns(2),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ta')
                    ->label('Tahun Ajaran')
                    ->searchable(),
                TextColumn::make('gel')
                    ->label('Gelombang')
                    ->searchable(),
                TextColumn::make('tgl_sel')
                    ->label('Tanggal Seleksi')
                    ->searchable(),
                TextColumn::make('ket')
                    ->label('Keterangan')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->label('Ubah Data'),

                Tables\Actions\Action::make('Seleksi')
                ->icon('heroicon-o-queue-list')
                ->url(function (Seleksi $record) {
                    return SeleksiResource::getUrl('seleksi', ['seleksi_id' => $record->id]);
                }),
                
                
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
            'index' => Pages\ListSeleksis::route('/'),
            'create' => Pages\CreateSeleksi::route('/create'),
            'edit' => Pages\EditSeleksi::route('/{record}/edit'),
            'seleksi' => Pages\SeleksiPeserta::route('/{seleksi_id}/seleksi-peserta'),

        ];
    }
}
