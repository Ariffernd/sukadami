<?php

namespace App\Filament\Resources\Ppdb;

use Filament\Forms;
use Filament\Tables;
use App\Models\Periode;
use App\Models\Regency;
use App\Models\Village;
use App\Models\District;
use App\Models\Formulir;
use App\Models\Province;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Ppdb\FormulirResource\Pages;
use Filament\Infolists\Components\Section as ComponentsSection;
use Marvinosswald\FilamentInputSelectAffix\TextInputSelectAffix;
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
                // DATA SISWA
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
                    TextInput::make('nisn')
                        ->numeric()
                        ->label('Nomor Induk Siswa Nasional (NISN)'),
                    TextInput::make('nik')
                        ->numeric()
                        ->label('Nomor Induk Kependudukan (NIK)')
                        ->required(),
                    TextInput::make('no_kk')
                        ->numeric()
                        ->label('Nomor Kartu Keluarga (NO. KK)')
                        ->required(),
                    TextInput::make('tl_lahir')
                        ->label('Tempat Lahir')
                        ->required(),
                    DatePicker::make('tg_lahir')
                        ->label('Tanggal Lahir')
                        ->required()
                        ->displayFormat('d/m/Y')
                        ->native(false),
                    Select::make('jk')
                        ->label('Jenis Kelamin')
                        ->options([
                            'L' => 'Laki-Laki',
                            'P' => 'Perempuan',
                        ])
                        ->native(false)
                        ->required(),
                    TextInput::make('cita')
                        ->label('Cita-Cita')
                        ->required(),
                    Select::make('agama')
                        ->required()
                        ->label('Agama')
                        ->options([
                            'Islam' => 'Islam',
                            'Kristen' => 'Kristen',
                            'Hindu' => 'Hindu',
                            'Budha' => 'Budha',
                            'Katolik' => 'Katolik',
                        ]),
                    TextInput::make('anak_ke')
                        ->label('Anak ke-')
                        ->required()
                        ->numeric(),
                    TextInput::make('anak_sdr')
                        ->label('Jumlah Saudara')
                        ->required()
                        ->numeric(),
                    Select::make('status_ank')
                        ->label('Status Anak')
                        ->required()
                        ->options([
                            '---' => '---',
                            'Yatim' => 'Yatim',
                            'Piatu' => 'Piatu',
                            'Yatim Piatu' => 'Yatim Piatu',
                        ]),
                    Select::make('tmpt_ank')
                        ->label('Tinggal Bersama')
                        ->required()
                        ->options([
                            'Orang Tua' => 'Orang Tua',
                            'Wali' => 'Wali',
                        ])
                ])->columns(3),

                // ALAMAT
                Section::make('Tempat Tinggal')->schema([
                    Textarea::make('alamat')
                        ->label('Alamat Lengkap')
                        ->required(),
                    TextInput::make('rt')
                        ->label('RT')
                        ->required(),
                    TextInput::make('rw')
                        ->label('RW')
                        ->required(),
                    Select::make('province_id')
                        ->required()
                        ->label('Provinsi')
                        ->searchable()
                        ->live()
                        ->options(Province::pluck('name', 'id')),

                    Select::make('regency_id')
                        ->required()
                        ->label('Kabupaten/ Kota')
                        ->searchable()
                        ->options(fn ($get) => Regency::where('province_id', $get('province_id'))->pluck('name', 'id')),

                    Select::make('district_id')
                        ->required()
                        ->label('Kecamatan')
                        ->searchable()
                        ->options(fn ($get) => District::where('regency_id', $get('regency_id'))->pluck('name', 'id')),

                    Select::make('village_id')
                        ->required()
                        ->label('Desa')
                        ->searchable()
                        ->options(fn ($get) => Village::where('district_id', $get('district_id'))->pluck('name', 'id')),
                    TextInputSelectAffix::make('jrk_rmh')
                        ->numeric()
                        ->select(
                            fn () => Forms\Components\Select::make('sat_jrk')
                                ->options([
                                    'M' => 'Meter',
                                    'KM' => 'Kilo Meter',
                                ])
                        ),
                    TextInputSelectAffix::make('wkt_tmph')
                        ->numeric()
                        ->select(
                            fn () => Forms\Components\Select::make('sat_tmph')
                                ->options([
                                    'Menit' => 'Menit',
                                    'Jam' => 'Jam',
                                ])
                        ),
                ])->columns(3),


                //DATA ORANG TUA AYAH
                Section::make('Data Ayah Kandung')->schema([
                    TextInput::make('nm_ayh')
                        ->label('Nama Lengkap Ayah')
                        ->required(),
                    TextInput::make('nik_ayh')
                        ->label('NIK Ayah')
                        ->required(),
                    DatePicker::make('thn_lh_ayh')
                        ->label('Tanggal Lahir Ayah')
                        ->required()
                        ->displayFormat('d/m/Y')
                        ->native(false),
                    Select::make('pend_ayh')
                        ->label('Pendidikan')
                        ->required()
                        ->searchable()
                        ->options([
                            'Tidak Sekolah' => 'Tidak Sekolah',
                            'SD' => 'SD',
                            'SMP/ SLTP' => 'SMP/ SLTP',
                            'SMA/ SMK/ SLTA' => 'SMA/ SMK/ SLTA',
                            'D3' => 'D3',
                            'S1' => 'S1',
                            'S2' => 'S2',
                            'S3' => 'S3',
                        ]),
                    TextInput::make('peker_ayh')
                        ->label('Pekerjaan Ayah')
                        ->required(),
                    TextInput::make('sal_ayh')
                        ->label('Pendapatan Per-bulan')
                        ->required(),
                    TextInput::make('no_telp_ayh')
                        ->label('Nomor Telp Ayah')
                        ->required(),



                ])->columns(2),

                //DATA ORANG TUA Ibu
                Section::make('Data Ibu Kandung')->schema([
                    TextInput::make('nm_ibu')
                        ->label('Nama Lengkap Ibu')
                        ->required(),
                    TextInput::make('nik_ibu')
                        ->label('NIK Ibu')
                        ->required(),
                    DatePicker::make('thn_lh_ibu')
                        ->label('Tanggal Lahir Ibu')
                        ->required()
                        ->displayFormat('d/m/Y')
                        ->native(false),
                    Select::make('pend_ibu')
                        ->label('Pendidikan')
                        ->required()
                        ->searchable()
                        ->options([
                            'Tidak Sekolah' => 'Tidak Sekolah',
                            'SD' => 'SD',
                            'SMP/ SLTP' => 'SMP/ SLTP',
                            'SMA/ SMK/ SLTA' => 'SMA/ SMK/ SLTA',
                            'D3' => 'D3',
                            'S1' => 'S1',
                            'S2' => 'S2',
                            'S3' => 'S3',
                        ]),
                    TextInput::make('peker_ibu')
                        ->label('Pekerjaan Ibu')
                        ->required(),
                    TextInput::make('sal_ibu')
                        ->label('Pendapatan Per-bulan')
                        ->required(),
                    TextInput::make('no_telp_ibu')
                        ->label('Nomor Telp Ibu')
                        ->required(),
                ])->columns(2),

                //DATA ORANG TUA Wali
                Section::make('Data Wali')->schema([
                    TextInput::make('nm_wali')
                        ->label('Nama Lengkap Wali'),
                    TextInput::make('nik_wali')
                        ->label('NIK Wali'),
                    DatePicker::make('thn_lh_wali')
                        ->label('Tanggal Lahir Wali')
                        ->displayFormat('d/m/Y')
                        ->native(false),
                    Select::make('pend_wali')
                        ->label('Pendidikan')
                        ->searchable()
                        ->options([
                            'Tidak Sekolah' => 'Tidak Sekolah',
                            'SD' => 'SD',
                            'SMP/ SLTP' => 'SMP/ SLTP',
                            'SMA/ SMK/ SLTA' => 'SMA/ SMK/ SLTA',
                            'D3' => 'D3',
                            'S1' => 'S1',
                            'S2' => 'S2',
                            'S3' => 'S3',
                        ]),
                    TextInput::make('peker_wali')
                        ->label('Pekerjaan Wali'),
                    TextInput::make('sal_wali')
                        ->label('Pendapatan Per-bulan'),
                    TextInput::make('no_telp_wali')
                        ->label('Nomor Telp Wali'),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Akun Pendaftar')
                    ->badge(),

                TextColumn::make('periode.ta')
                    ->label('Tahun Ajaran')
                    ->badge(),
                TextColumn::make('periode.gel')
                    ->label('Gelombang')
                    ->badge(),
                TextColumn::make('nama')
                    ->label('Nama Siswa'),
                TextColumn::make('tg_lahir')
                    ->label('Tanggal Lahir'),
                TextColumn::make('jk')
                    ->label('Jenis Kelamin'),
                
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
