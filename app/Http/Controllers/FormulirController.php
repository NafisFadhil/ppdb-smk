<?php

namespace App\Http\Controllers;

use App\Helpers\ModelHelper;
use App\Jobs\ResetTagihan;
use App\Jobs\ResetVerifikasi;
use App\Jobs\TambahPeserta;
use App\Jobs\UpdatePeserta;
use App\Models\DUSeragam;
use App\Models\Identitas;
use App\Models\DataJalurPendaftaran;
use App\Models\DataJenisKelamin;
use App\Models\Jurusan;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\Seragam;
use App\Models\Tagihan;
use App\Models\Verifikasi;
use App\Validations\IdentitasValidation;
use App\Validations\JurusanValidation;
use App\Validations\SeragamValidation;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Session;

class FormulirController extends Controller
{

    // public $identitas;

    protected $identitas;
    protected $identitas_creden;
    protected $seragam_creden;

    public static $kode_pendaftaran;
    
    private $validation_names = [
        'jalur_pendaftaran_id', 
        'sub_jalur_pendaftaran_id', 
        'nama_lengkap', 
        'tanggal_lahir', 
        'jenis_kelamin_id', 
        'asal_sekolah', 
        'no_wa_siswa', 
        'no_wa_ortu', 
        'nama_jurusan', 
    ];

    private $validation_siswanames = [
        'no_wa_siswa',
        'no_wa_ortu',
        'tempat_lahir',
        'alamat_desa',
        'alamat_kec',
        'alamat_kota_kab',
        'alamat_rt',
        'alamat_rw',
        'alamat_gg',
        'nama_ayah',
        'tahun_lahir_ayah',
        'nama_ibu',
        'tahun_lahir_ibu',
        'jumlah_saudara_kandung',
        'nik',
        'nisn',
        'no_ujian_nasional',
        'no_ijazah',
    ];

    private $validation_admnames = [
        'jalur_pendaftaran_id', 
        'sub_jalur_pendaftaran_id', 
        'nama_lengkap', 
        'tanggal_lahir', 
        'jenis_kelamin_id', 
        'asal_sekolah', 
        'no_wa_siswa', 
        'nama_jurusan',
        // Advanced Form Inputs
        'no_wa_ortu',
        'tempat_lahir',
        'alamat_desa',
        'alamat_kec',
        'alamat_kota_kab',
        'alamat_rt',
        'alamat_rw',
        'alamat_gg',
        'nama_ayah',
        'tahun_lahir_ayah',
        'nama_ibu',
        'tahun_lahir_ibu',
        'jumlah_saudara_kandung',
        'nik',
        'nisn',
        'no_ujian_nasional',
        'no_ijazah',
    ];

    protected function getFormInputs (Identitas $data = null)
    {
        $jurusan =  Cache::rememberForever('jurusan_options', fn() => Jurusan::getOptions());
        $jenis_kelamins = Cache::rememberForever('jenis_kelamin_options', fn() => DataJenisKelamin::getOptions());

        return [
            ...DataJalurPendaftaran::getFormInput(),
            [
                'type' => 'text', 'name' => 'nama_lengkap', 'value' => $data->nama_lengkap??null,
                'label' => null, 'placeholder' => null, 'opts' => ['uppercase','required']
            ], 
            [
                'type' => 'radio', 'name' => 'jenis_kelamin_id', 'value' => $data->jenis_kelamin??null,
                'label' => 'Jenis Kelamin', 'placeholder' => null, 'values' => $jenis_kelamins,
                'opts' => ['required']
            ],
            [
                'type' => 'date', 'name' => 'tanggal_lahir', 'value' => $data->tanggal_lahir??null,
                'label' => null, 'placeholder' => null , 'opts' => ['required']
            ], 
            [
                'type' => 'text', 'name' => 'asal_sekolah', 'value' => $data->asal_sekolah??null,
                'label' => null, 'placeholder' => null, 'opts' => ['uppercase','required']
            ], 
            [
                'type' => 'number', 'name' => 'no_wa_siswa', 'value' => $data->no_wa_siswa??null,
                'label' => 'No WA Siswa', 'placeholder' => 'Cth. 08123456789' , 'opts' => ['required']
            ], 
            [
                'type' => 'number', 'name' => 'no_wa_ortu', 'value' => $data->no_wa_ortu??null,
                'label' => 'WA Orang Tua/Wali', 'placeholder' => '(Opsional)' , 'opts' => ['required']
            ],
            [
                'type' => 'select', 'name' => 'nama_jurusan', 'value' => $data->nama_jurusan??null,
                'label' => null, 'placeholder' => null, 'options' => $jurusan, 'opts' => ['required']
            ],
        ];
    }

    protected function getAdvancedFormInputs (Identitas $data = null)
    {
        $jurusan =  Cache::rememberForever('jurusan_options', fn() => Jurusan::getOptions());
        $jenis_kelamins = Cache::rememberForever('jenis_kelamin_options', fn() => DataJenisKelamin::getOptions());
        // $seragam = Cache::rememberForever('seragam_options', fn() => Seragam::getOptions());

        return [
            ...DataJalurPendaftaran::getFormInput($data),
            [
                'type' => 'text', 'name' => 'nama_lengkap', 'value' => $data->nama_lengkap??null,
                'label' => null, 'placeholder' => null, 'opts' => ['required', 'uppercase']
            ],
            [
                'type' => 'text', 'name' => 'tempat_lahir', 'value' => $data->tempat_lahir??null,
                'label' => null, 'placeholder' => null, 'opts' => ['uppercase']
            ],
            [
                'type' => 'date', 'name' => 'tanggal_lahir', 'value' => $data->tanggal_lahir??null,
                'label' => null, 'placeholder' => null, 'opts' => ['required']
            ],
            [
                'type' => 'radio', 'name' => 'jenis_kelamin_id', 'value' => $data->jenis_kelamin??null,
                'label' => 'Jenis Kelamin', 'placeholder' => null, 'values' => $jenis_kelamins,
                'opts' => ['required']
            ],
            [
                'type' => 'text', 'name' => 'alamat_desa', 'value' => $data->alamat_desa??null,
                'label' => null, 'placeholder' => null, 'opts' => ['uppercase']
            ],
            [
                'type' => 'text', 'name' => 'alamat_kec', 'value' => $data->alamat_kec??null,
                'label' => null, 'placeholder' => null, 'opts' => ['uppercase']
            ],
            [
                'type' => 'text', 'name' => 'alamat_kota_kab', 'value' => $data->alamat_kota_kab??null,
                'label' => null, 'placeholder' => null, 'opts' => ['uppercase']
            ],
            [
                'type' => 'number', 'name' => 'alamat_rt', 'value' => $data->alamat_rt??null,
                'label' => null, 'placeholder' => null
            ],
            [
                'type' => 'number', 'name' => 'alamat_rw', 'value' => $data->alamat_rw??null,
                'label' => null, 'placeholder' => null
            ],
            [
                'type' => 'text', 'name' => 'nama_ayah', 'value' => $data->nama_ayah??null,
                'label' => null, 'placeholder' => null, 'opts' => ['uppercase']
            ],
            [
                'type' => 'text', 'name' => 'nama_ibu', 'value' => $data->nama_ibu??null,
                'label' => null, 'placeholder' => null, 'opts' => ['uppercase']
            ],
            [
                'type' => 'number', 'name' => 'jumlah_saudara_kandung', 'value' => $data->jumlah_saudara_kandung??null,
                'label' => null, 'placeholder' => null
            ],
            [
                'type' => 'number', 'name' => 'nik', 'value' => $data->nik??null,
                'label' => null, 'placeholder' => null
            ],
            [
                'type' => 'text', 'name' => 'asal_sekolah', 'value' => $data->asal_sekolah??null,
                'label' => null, 'placeholder' => null, 'opts' => ['required', 'uppercase']
            ],
            [
                'type' => 'number', 'name' => 'nisn', 'value' => $data->nisn??null,
                'label' => null, 'placeholder' => null
            ],
            [
                'type' => 'number', 'name' => 'no_ujian_nasional', 'value' => $data->no_ujian_nasional??null,
                'label' => null, 'placeholder' => null
            ],
            [
                'type' => 'number', 'name' => 'no_ijazah', 'value' => $data->no_ijazah??null,
                'label' => null, 'placeholder' => null
            ],
            [
                'type' => 'number', 'name' => 'no_wa_siswa', 'value' => $data->no_wa_siswa??null,
                'label' => 'No WA Siswa', 'placeholder' => 'Cth. 08123456789', 'opts' => ['required']
            ],
            [
                'type' => 'number', 'name' => 'no_wa_ortu', 'value' => $data->no_wa_ortu??null,
                'label' => null, 'placeholder' => null
            ],
            [
                'type' => 'select', 'name' => 'nama_jurusan', 'value' => $data->nama_jurusan??null,
                'label' => null, 'placeholder' => null, 'options' => $jurusan,
                'opts' => ['required', 'uppercase']
            ],
            [
                'type' => 'select', 'name' => 'ukuran_seragam', 'value' => $data->duseragam->ukuran_seragam??null,
                'options' => []
            ],
        ];
    }

    public static function getMultiFormInputs (Identitas $data = null)
    {
        $jurusan =  Cache::rememberForever('jurusan_options', fn() => Jurusan::getOptions());
        $jenis_kelamins = Cache::rememberForever('jenis_kelamin_options', fn() => DataJenisKelamin::getOptions());
        // $tanggal_lahir = isset($data->tanggal_lahir) ? date('Y-m-d', $data->tanggal_lahir) : null;

        return [
            ['title' => 'Data Pokok', 'inputs' => [
                    ...DataJalurPendaftaran::getFormInput($data),
                [
                    'type' => 'text', 'name' => 'nama_lengkap', 'value' => $data->nama_lengkap??null,
                    'label' => null, 'placeholder' => null, 'opts' => ['required', 'uppercase']
                ],
                [
                    'type' => 'text', 'name' => 'tempat_lahir', 'value' => $data->tempat_lahir??null,
                    'label' => null, 'placeholder' => null, 'opts' => ['uppercase']
                ],
                [
                    'type' => 'date', 'name' => 'tanggal_lahir', 'value' => $data->tanggal_lahir??null,
                    'label' => null, 'placeholder' => null, 'opts' => ['required']
                ], 
                [
                    'type' => 'radio', 'name' => 'jenis_kelamin_id', 'value' => $data->jenis_kelamin_id??null,
                    'label' => 'Jenis Kelamin', 'placeholder' => null, 
                    'values' => $jenis_kelamins, 'opts' => ['required']
                ],
                [
                    'type' => 'text', 'name' => 'asal_sekolah', 'value' => $data->asal_sekolah??null,
                    'label' => null, 'placeholder' => null, 'opts' => ['required', 'uppercase']
                ],
                [
                    'type' => 'select', 'name' => 'nama_jurusan', 'value' => strtolower($data->jurusan->singkatan??''),
                    'label' => null, 'placeholder' => null, 'options' => $jurusan, 'opts' => ['required']
                ],
            ]],
            ['title' => 'Data Lokasi', 'inputs' => [
                [
                    'type' => 'text', 'name' => 'alamat_desa', 'value' => $data->alamat_desa??null,
                    'label' => null, 'placeholder' => null, 'opts' => ['uppercase']
                ],
                [
                    'type' => 'text', 'name' => 'alamat_kec', 'value' => $data->alamat_kec??null,
                    'label' => null, 'placeholder' => null, 'opts' => ['uppercase']
                ],
                [
                    'type' => 'text', 'name' => 'alamat_kota_kab', 'value' => $data->alamat_kota_kab??null,
                    'label' => null, 'placeholder' => null, 'opts' => ['uppercase']
                ],
                [
                    'type' => 'number', 'name' => 'alamat_rt', 'value' => $data->alamat_rt??null,
                    'label' => null, 'placeholder' => null
                ],
                [
                    'type' => 'number', 'name' => 'alamat_rw', 'value' => $data->alamat_rw??null,
                    'label' => null, 'placeholder' => null
                ],
                [
                    'type' => 'number', 'name' => 'alamat_gg', 'value' => $data->alamat_gg??null,
                    'label' => null, 'placeholder' => null
                ],
            ]],
            ['title' => 'Data Keluarga', 'inputs' => [
                [
                    'type' => 'text', 'name' => 'nama_ayah', 'value' => $data->nama_ayah??null,
                    'label' => null, 'placeholder' => null, 'opts' => ['uppercase']
                ],
                [
                    'type' => 'number', 'name' => 'tahun_lahir_ayah', 'value' => $data->tahun_lahir_ayah??null,
                    'label' => null, 'placeholder' => null,
                ],
                [
                    'type' => 'text', 'name' => 'nama_ibu', 'value' => $data->nama_ibu??null,
                    'label' => null, 'placeholder' => null, 'opts' => ['uppercase']
                ],
                [
                    'type' => 'number', 'name' => 'tahun_lahir_ibu', 'value' => $data->tahun_lahir_ibu??null,
                    'label' => null, 'placeholder' => null,
                ],
                [
                    'type' => 'number', 'name' => 'jumlah_saudara_kandung', 'value' => $data->jumlah_saudara_kandung??null,
                    'label' => null, 'placeholder' => null
                ],
            ]],
            ['title' => 'Data Nasional', 'inputs' => [
                [
                    'type' => 'number', 'name' => 'nik', 'value' => $data->nik??null,
                    'label' => null, 'placeholder' => null
                ],
                [
                    'type' => 'number', 'name' => 'nisn', 'value' => $data->nisn??null,
                    'label' => null, 'placeholder' => null
                ],
                [
                    'type' => 'number', 'name' => 'no_ujian_nasional', 'value' => $data->no_ujian_nasional??null,
                    'label' => null, 'placeholder' => null
                ],
                [
                    'type' => 'number', 'name' => 'no_ijazah', 'value' => $data->no_ijazah??null,
                    'label' => null, 'placeholder' => null
                ],
            ]],
            ['title' => 'Data Komunikasi', 'inputs' => [
                [
                    'type' => 'number', 'name' => 'no_wa_siswa', 'value' => $data->no_wa_siswa??null,
                    'label' => 'No WA Siswa', 'placeholder' => 'Cth. 08123456789', 'opts' => ['required']]
                    , 
                [
                    'type' => 'number', 'name' => 'no_wa_ortu', 'value' => $data->no_wa_ortu??null,
                    'label' => null, 'placeholder' => null
                ],
                
            ]],
            ['title' => 'Data Seragam', 'inputs' => Seragam::getInputs($data)]
        ];
    }

    // Landing Page Formulir Pendaftaran
    public function index ()
    {
        return view('pages.pendaftaran', [
            'page' => ['title' => 'Formulir Pendaftaran'],
            'inputs' => $this->getFormInputs(),
        ]);
    }

    // Admin Tambah Peserta
    public function tambah ()
    {
        return view('admin.pages.forms', [
            'page' => ['title' => 'Tambah Pendaftaran'],
            'form' => [
                'variant' => 'multiform',
                'cols' => 'col-12',
                'action' => '/admin/tambah-peserta',
                'button' => [
                    'variant' => 'primary text-white',
                    'content' => '<i class="fa fa-plus"></i> Tambah Data',
                ],
                'inputs' => static::getMultiFormInputs()
            ],
        ]);
    }

    public function store(Request $req)
    {
        $isadmin = $req->user()->level_id ?? 1 !== 1;
        
        // Initiation Credentials
        $identitas_creden = $req->validate(IdentitasValidation::getValidations(
            $isadmin ? $this->validation_admnames : $this->validation_names
        ));
        $onage = Identitas::validateAge($identitas_creden['tanggal_lahir']);

        if (!$onage) {
            return back()->withErrors([
                'alerts' => [
                    $isadmin?'danger':'error' => 'Maaf, umur tidak memenuhi kriteria pendaftaran.'
                ]
            ])->withInput($identitas_creden);
        }

        try {
            
            // Queue Database Transaction
            $id = rand(1000000, 1000000000000);
            TambahPeserta::dispatch($identitas_creden, $id);

            if (!$isadmin) {
                Session::put('session_id', $id);
                $alerts['primary'] = 'Mohon refresh halaman jika kode pendaftaran belum muncul.';
            } else $alerts['info'] = 'Mohon refresh halaman jika kode pendaftaran belum muncul.';

            $alerts['success'] = 'Pendaftaran berhasil.';
            $redir_path = $isadmin ? session('oldpath', '/admin/peserta') : '/';

            return redirect($redir_path)->withErrors([
                'alerts' => $alerts
            ]);

        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['error' => 'Maaf, terjadi kesalahan saat memproses data.']
            ])->withInput($identitas_creden);
        }
    }

    public function edit(Identitas $identitas)
    {
        session(['oldpath', '/'.request()->path()]);
        return view('admin.pages.forms', [
            'page' => ['title' => 'Edit Data Pendaftaran'],
            'data' => $identitas,
            'form' => [
                'variant' => 'multiform',
                'cols' => 'col-12',
                'action' => '/admin/edit/'.$identitas->id,
                'button' => [
                    'variant' => 'warning text-white',
                    'content' => '<i class="fa fa-pen"></i> Edit Data',
                ],
                'inputs' => $this->getMultiFormInputs($identitas)
            ],
        ]);
    }

    // protected $identitas;
    public function update(Request $req, Identitas $identitas)
    {
        $isadmin = $req->user()->level->name !== 'siswa';

        // Initiation Credentials
        $identitas_creden = $req->validate(IdentitasValidation::getValidations(
            $isadmin ? $this->validation_admnames : $this->validation_siswanames
        ));
        $seragam_creden = $req->validate(SeragamValidation::getValidations(
            $isadmin ? ['ukuran_olahraga', 'ukuran_wearpack', 'ukuran_almamater'] : []
        ));
        $tagihan_creden = [];
        $verifikasi_creden = [];
        $jurusan_creden = [];
        $alerts = [];

        try {

            if ($isadmin) {

                // Alur Logika Jalur Pendaftaran
                $identitas_creden = Identitas::getSubPrestasi($identitas_creden);
                
                // Parse Nama Jurusan
                $jurusan = Jurusan::getJurusan($identitas_creden['nama_jurusan']);
                unset($identitas_creden['nama_jurusan']);
                
                // Checking State
                $pindah_jalur = (int) $identitas_creden['jalur_pendaftaran_id'] !== (int) $identitas->jalur_pendaftaran_id;
                $pindah_jurusan = strtolower($jurusan->singkatan) !== strtolower($identitas->jurusan->singkatan);
    
                // Get Jalur Pendaftaran
                $jalur = DataJalurPendaftaran::getJalurPendaftaran(
                    $identitas_creden['jalur_pendaftaran_id']
                );
    
                // Handle Pindah Jalur
                if ($pindah_jalur || $pindah_jurusan) {
                    
                    // Dispatch Job Reset Tagihan
                    ResetTagihan::dispatchSync($identitas, $jalur);
    
                    // Dispatch Job Reset Verifikasi
                    ResetVerifikasi::dispatchSync($identitas);
    
                    // Jurusan Mocking
                    if ($pindah_jurusan) {
                        $jurusan_creden = [
                            'nama' => $jurusan->nama,
                            'slug' => $jurusan->slug,
                            'singkatan' => $jurusan->singkatan,
                        ];
                    }
    
                    // Identitas Mocking
                    $identitas_creden['status_id'] = 1;
                }
    
                // Database Transaction
                if (!empty($jurusan_creden)) $identitas->jurusan->update($jurusan_creden);
                if (!empty($tagihan_creden)) $identitas->tagihan->update($tagihan_creden);
                if (!empty($verifikasi_creden)) $identitas->verifikasi->update($verifikasi_creden);
                if (!empty($seragam_creden)) $identitas->seragam->update($seragam_creden);

            }
            
            $identitas->update($identitas_creden);

            $alerts['success'] = ' Berhasil mengubah data.';
            $redir_path = session('oldpath', '/admin/peserta');

            return redirect($redir_path)->withErrors([ 'alerts' => $alerts ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memperbarui data. Mohon hubungi penyedia layanan untuk pengembangan.']
            ])->withInput($req->toArray());
        }

    }

}
