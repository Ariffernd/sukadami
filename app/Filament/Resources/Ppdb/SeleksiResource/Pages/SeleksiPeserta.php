<?php

namespace App\Filament\Resources\Ppdb\SeleksiResource\Pages;


use App\Models\SeleksiPd;
use Filament\Tables\Table;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Filament\Resources\Ppdb\SeleksiResource;
use Filament\Tables\Concerns\InteractsWithTable;



class SeleksiPeserta extends Page implements HasForms, HasTable
{
    protected static string $resource = SeleksiResource::class;
    protected static ?string $model = SeleksiPd::class;
    protected static string $view = 'filament.resources.ppdb.seleksi-resource.pages.seleksi-peserta';
    protected static ?string $title = 'Seleksi Peserta Didik';

    use InteractsWithTable;
    use InteractsWithForms;


    protected $record;

    public function mount(SeleksiPd $record): void
    {
        $this->record = $record;
    }

    public function getTableQuery(): Builder
    {
        return SeleksiPd::query()->where("seleksi_id", $this->record->seleksi_id ?? 'default_value');
    }

    public function table(Table $table): Table
    {
        return $table
            ->searchable()
            ->query(SeleksiPd::query())
            ->columns([
                TextColumn::make('formulir.nama')
                    ->label("Nama Peserta Didik"),
                TextColumn::make('formulir.tg_lahir')
                    ->label("Usia Peserta Didik")
                    ->formatStateUsing(function ($state) {
                        return now()->diffInYears($state) . ' tahun ' . now()->diffInMonths($state) % 12 . ' bulan';
                    }),

                TextColumn::make('hasil')
                    ->label("Status Seleksi")
                    ->badge(),
            ])
            ->actions([
                \Filament\Tables\Actions\Action::make('Seleksi Peserta Didik')
                    ->icon('heroicon-o-document-check')
                    ->form([
                        \Filament\Forms\Components\Select::make('hasil')
                            ->label('Hasil Seleksi')
                            ->options([
                                'Proses Seleksi' => 'Proses Seleksi',
                                'Lulus' => 'Lulus',
                                'Tidak Lulus' => 'Tidak Lulus',
                            ])
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update(['hasil' => $data['hasil']]);
                        Notification::make()
                            ->success()
                            ->title('Proses Seleksi Disimpan!')
                            ->send();
                    })
            ])

            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('Seleksi Peserta Didik')
                        ->icon('heroicon-o-document-check')
                        ->color('success')
                        ->form([
                            \Filament\Forms\Components\Select::make('hasil')
                                ->label('Hasil Seleksi')
                                ->options([
                                    'Proses Seleksi' => 'Proses Seleksi',
                                    'Lulus' => 'Lulus',
                                    'Tidak Lulus' => 'Tidak Lulus',
                                ])
                                ->searchable()
                                ->required(),
                        ])
                        ->action(function ($records, array $data) {
                            foreach ($records as $record) {
                                $record->update(['hasil' => $data['hasil']]);
                            }
                            Notification::make()
                                ->success()
                                ->title('Proses Seleksi Disimpan!')
                                ->send();
                        }),
                ]),
            ])
            ->filters([]);
    }
}
