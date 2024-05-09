<?php

namespace App\Filament\Pages;

use App\Models\{Periode, Regency, Village, District, Province, Formulir as FormulirModel};
use Filament\Forms\{Form, Components\Select, Components\Section, Components\Textarea, Components\TextInput, Components\DatePicker, Components\FileUpload};
use Filament\Pages\Page;
use Filament\Actions\Action;
use Illuminate\Support\Facades\DB;
use Filament\Support\Exceptions\Halt;
use Filament\Notifications\Notification;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Marvinosswald\FilamentInputSelectAffix\TextInputSelectAffix;

class Formulir extends Page implements HasForms
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.formulir';
    protected static ?string $navigationGroup = 'PPDB';
    protected static ?string $navigationLabel = 'Formulir PPDB';
    use InteractsWithForms;

    public ?array $data = [];
    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        $userId = auth()->id();
        $isFilled = FormulirModel::where('user_id', $userId)->exists();
        if ($isFilled) {
            return $form->schema([
            Section::make('Formulir Anda Sudah Kami Terima!'),
            ])->statePath('data');
        } else {
            return $form->schema([
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
                        ->autofocus()
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
                        ]),
                    Section::make('Data Periodik Siswa')->schema([
                        TextInput::make('anak_ke')
                            ->label('Anak ke-')
                            ->required()
                            ->numeric(),
                        TextInput::make('anak_sdr')
                            ->label('Jumlah Saudara')
                            ->required()
                            ->numeric(),
                        TextInputSelectAffix::make('brt_bdn')
                            ->label('Berat Badan')
                            ->numeric()
                            ->select(
                                fn () => Select::make('sat_brt')
                                    ->options([
                                        'Kg' => 'Kg',
                                    ])
                            ),
                        TextInputSelectAffix::make('tngi_bdn')
                            ->label('Tinggi Badan')
                            ->numeric()
                            ->select(
                                fn () => Select::make('sat_tngi')
                                    ->options([
                                        'Cm' => 'Cm',
                                    ])
                            ),
                        TextInputSelectAffix::make('lkrkp')
                            ->label('Lingkar Kepala')
                            ->numeric()
                            ->select(
                                fn () => Select::make('sat_lkrkp')
                                    ->options([
                                        'Cm' => 'Cm',
                                    ])
                            ),
                        TextInput::make('asal_sklh')
                            ->label('Asal Sekolah TK/ KB/ PAUD'),
                    ])->columns(2)
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
                        ->label('Jarak Dari Rumah Ke Sekolah')
                        ->numeric()
                        ->select(
                            fn () => Select::make('sat_jrk')
                                ->options([
                                    'M' => 'Meter',
                                    'KM' => 'Kilometer',
                                ])
                        ),
                    TextInputSelectAffix::make('wkt_tmph')
                        ->label('Waktu Tempuh Dari Rumah Ke Sekolah')
                        ->numeric()
                        ->select(
                            fn () => Select::make('sat_tmph')
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
                        ->numeric()
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
                        ->required()
                        ->numeric()
                        ->tel()
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
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
                        ->required()
                        ->tel()
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
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
                        ->label('Nomor Telp Wali')
                        ->tel()
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                ])->columns(2),

                Section::make('Upload File')->schema([
                    FileUpload::make('ijazah')
                        ->required()
                        ->openable()
                        ->downloadable(),
                    FileUpload::make('kk')
                        ->required()
                        ->openable()
                        ->downloadable(),
                    FileUpload::make('akte')
                        ->required()
                        ->openable()
                        ->downloadable()

                ])->columns(3),
            ])->statePath('data');
        }
    }


    public function getFormActions()
    {
        return [
            Action::make('save')->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        try {
            FormulirModel::create($data);
        } catch (Halt $ex) {
            return;
        }
        Notification::make()->success()->title('Data Berhasil Diubah!')->send();
    }
}
