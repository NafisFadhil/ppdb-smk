<?php

namespace App\Http\Controllers;

use App\Models\DUSeragam;
use App\Models\Identitas;
use App\Models\JalurPendaftaran;
use App\Models\Jurusan;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\Tagihan;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormulirController extends Controller
{

    protected $myValidations = [
        'jalur_pendaftaran_id', 
        'sub_jalur_pendaftaran_id', 
        'nama_lengkap', 
        'tanggal_lahir', 
        'jenis_kelamin', 
        'asal_sekolah', 
        'no_wa_siswa', 
        'no_wa_ortu', 
        'nama_jurusan', 
    ];

    protected $admValidations = [
        'jalur_pendaftaran_id', 
        'sub_jalur_pendaftaran_id', 
        'nama_lengkap', 
        'tanggal_lahir', 
        'jenis_kelamin', 
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
        'nama_ayah',
        'nama_ibu',
        'jumlah_saudara_kandung',
        'nik',
        'nisn',
        'no_ujian_nasional',
        'no_ijazah',
    ];

    protected $duseragamValidations = [
        'ukuran_seragam'
    ];
    
    protected function getFormInputs (Identitas $data = null)
    {
        $jurusan = Jurusan::getOptions();
        $kelamins = ['LAKI-LAKI', 'PEREMPUAN'];

        return [
            ...JalurPendaftaran::getFormInput(),
            ['type' => 'text', 'name' => 'nama_lengkap', 'value' => $data->nama_lengkap??null,
                'label' => null, 'placeholder' => null, 'opts' => ['uppercase']], 
            ['type' => 'radio', 'name' => 'jenis_kelamin', 'value' => $data->jenis_kelamin??null,
                'label' => null, 'placeholder' => null, 'values' => $kelamins],
            ['type' => 'date', 'name' => 'tanggal_lahir', 'value' => $data->tanggal_lahir??null,
                'label' => null, 'placeholder' => null ], 
            ['type' => 'text', 'name' => 'asal_sekolah', 'value' => $data->asal_sekolah??null,
                'label' => null, 'placeholder' => null, 'opts' => ['uppercase']], 
            ['type' => 'number', 'name' => 'no_wa_siswa', 'value' => $data->no_wa_siswa??null,
                'label' => 'WA Siswa', 'placeholder' => 'Cth. 08123456789' ], 
            ['type' => 'number', 'name' => 'no_wa_ortu', 'value' => $data->no_wa_ortu??null,
                'label' => 'WA Orang Tua/Wali', 'placeholder' => '(Opsional)' ],
            ['type' => 'select', 'name' => 'nama_jurusan', 'value' => $data->nama_jurusan??null,
                'label' => null, 'placeholder' => null, 'options' => $jurusan],
        ];
    }

    protected function getAdvancedFormInputs (Identitas $data = null)
    {
        $jurusan = Jurusan::getOptions();
        $kelamins = ['LAKI-LAKI', 'PEREMPUAN'];

        return [
            ...JalurPendaftaran::getFormInput($data),
            ['type' => 'text', 'name' => 'nama_lengkap', 'value' => $data->nama_lengkap??null,
                'label' => null, 'placeholder' => null, 'opts' => ['required', 'uppercase']], 
            ['type' => 'text', 'name' => 'tempat_lahir', 'value' => $data->tempat_lahir??null,
                'label' => null, 'placeholder' => null, 'opts' => ['uppercase']],
            ['type' => 'date', 'name' => 'tanggal_lahir', 'value' => $data->tanggal_lahir??null,
                'label' => null, 'placeholder' => null, 'opts' => ['required']], 
            ['type' => 'radio', 'name' => 'jenis_kelamin', 'value' => $data->jenis_kelamin??null,
                'label' => null, 'placeholder' => null, 'values' => $kelamins, 'opts' => ['required']],
            ['type' => 'text', 'name' => 'alamat_desa', 'value' => $data->alamat_desa??null,
                'label' => null, 'placeholder' => null, 'opts' => ['uppercase']],
            ['type' => 'text', 'name' => 'alamat_kec', 'value' => $data->alamat_kec??null,
                'label' => null, 'placeholder' => null, 'opts' => ['uppercase']],
            ['type' => 'text', 'name' => 'alamat_kota_kab', 'value' => $data->alamat_kota_kab??null,
                'label' => null, 'placeholder' => null, 'opts' => ['uppercase']],
            ['type' => 'number', 'name' => 'alamat_rt', 'value' => $data->alamat_rt??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'number', 'name' => 'alamat_rw', 'value' => $data->alamat_rw??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'text', 'name' => 'nama_ayah', 'value' => $data->nama_ayah??null,
                'label' => null, 'placeholder' => null, 'opts' => ['uppercase']],
            ['type' => 'text', 'name' => 'nama_ibu', 'value' => $data->nama_ibu??null,
                'label' => null, 'placeholder' => null, 'opts' => ['uppercase']],
            ['type' => 'number', 'name' => 'jumlah_saudara_kandung', 'value' => $data->jumlah_saudara_kandung??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'number', 'name' => 'nik', 'value' => $data->nik??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'text', 'name' => 'asal_sekolah', 'value' => $data->asal_sekolah??null,
                'label' => null, 'placeholder' => null, 'opts' => ['required', 'uppercase']], 
            ['type' => 'number', 'name' => 'nisn', 'value' => $data->nisn??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'number', 'name' => 'no_ujian_nasional', 'value' => $data->no_ujian_nasional??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'number', 'name' => 'no_ijazah', 'value' => $data->no_ijazah??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'number', 'name' => 'no_wa_siswa', 'value' => $data->no_wa_siswa??null,
                'label' => 'WA Siswa', 'placeholder' => 'Cth. 08123456789', 'opts' => ['required']], 
            ['type' => 'number', 'name' => 'no_wa_ortu', 'value' => $data->no_wa_ortu??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'select', 'name' => 'nama_jurusan', 'value' => $data->nama_jurusan??null,
                'label' => null, 'placeholder' => null, 'options' => $jurusan, 'opts' => ['required', 'uppercase']],
            ['type' => 'select', 'name' => 'ukuran_seragam', 'value' => $data->duseragam->ukuran_seragam??null, 'options' => [
                ['label' => '--Pilih Ukuran Seragam--', 'value' => ''],
                'S', 'M', 'L', 'XL', 'XXL', 'XXXL'
            ]],
        ];
    }

    protected function validateRecaptcha (Request $req)
    {
        if (!$req->has('g-recaptcha-response') || !$req->get('g-recaptcha-response')) {
            return redirect('/formulir')->withErrors([
                'alerts' => ['danger' => 'Invalid reCAPTCHA!']
            ])->withInput($req->toArray());
        }

        $rawurl = 'https://www.google.com/recaptcha/api/siteverify?secret=%s&response=%s&remoteip=%s';
        $token = $req->get('g-recaptcha-response');
        $secretkey = env('RECAPTCHA_SECRET_KEY');
        $clientip = $req->ip();
        
        $url = sprintf($rawurl, $secretkey, $token, $clientip);
        // $result = file_get_contents($url);
        // $response = json_decode($result, true);

        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $url);
        $contents = curl_exec($c);
        curl_close($c);

        $response = json_decode($contents, true);

        if (!$contents && !isset($response['success']) && !$response['success']) {
            return redirect('/formulir')->withErrors([
                'alerts' => ['danger' => 'Invalid reCAPTCHA!']
            ])->withInput($req->toArray());
        }
    }

    public function index ()
    {
        return view('pages.formulir', [
            'page' => ['title' => 'Formulir Pendaftaran'],
            'inputs' => $this->getFormInputs(),
        ]);
    }

    public function tambah ()
    {
        return view('admin.pages.forms', [
            'page' => ['title' => 'Tambah Pendaftaran'],
            'form' => [
                'action' => '/admin/tambah-peserta',
                'button' => [
                    'variant' => 'btn-primary text-white',
                    'content' => '<i class="fa fa-plus"></i> Tambah Data',
                ],
                'inputs' => $this->getAdvancedFormInputs()
            ],
        ]);
    }

    public function store(Request $req)
    {
        $isadmin = $req->user()->level_id ?? 1 !== 1;
        
        // if (!$isadmin) {
        //     if (!$req->has('g-recaptcha-response') || !$req->get('g-recaptcha-response')) {
        //         return back()->withErrors([
        //             'alerts' => ['error' => 'Invalid reCAPTCHA!']
        //         ])->withInput($req->toArray());
        //     }
    
        //     $rawurl = 'https://www.google.com/recaptcha/api/siteverify?secret=%s&response=%s&remoteip=%s';
        //     $token = $req->get('g-recaptcha-response');
        //     $secretkey = env('RECAPTCHA_SECRET_KEY');
        //     $clientip = $req->ip();
            
        //     $url = sprintf($rawurl, $secretkey, $token, $clientip);
        //     // $result = file_get_contents($url);
        //     // $response = json_decode($result, true);
    
        //     $c = curl_init();
        //     curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        //     curl_setopt($c, CURLOPT_URL, $url);
        //     $contents = curl_exec($c);
        //     curl_close($c);
    
        //     $response = json_decode($contents, true);
    
        //     if (!$contents && !isset($response['success']) && !$response['success']) {
        //         return back()->withErrors([
        //             'alerts' => ['error' => 'Invalid reCAPTCHA!']
        //         ])->withInput($req->toArray());
        //     }
        // }
        
        $creden = $req->validate(Identitas::getValidations(
            $isadmin ? $this->admValidations : $this->myValidations
        ));
        
        try {

            $creden = Identitas::getSubPrestasi($creden);
            $duscreden = $req->validate(DUSeragam::getValidations($this->duseragamValidations));
    
            $onage = Identitas::validateAge($creden['tanggal_lahir']);
            if (!$onage) {
                return back()->withErrors([
                    'alerts' => [$isadmin?'danger':'error' => 'Maaf, umur tidak memenuhi kriteria pendaftaran.']
                ])->withInput($creden);
            }
        
            $identitas = Identitas::create($creden);
            $tagihan = Tagihan::create([
                'biaya_pendaftaran' => $identitas->jalur_pendaftaran->biaya_pendaftaran,
                'tagihan_pendaftaran' => $identitas->jalur_pendaftaran->biaya_pendaftaran,
                'biaya_daftar_ulang' => $identitas->jalur_pendaftaran->biaya_daftar_ulang,
                'tagihan_daftar_ulang' => $identitas->jalur_pendaftaran->biaya_daftar_ulang,
                'biaya_seragam' => $identitas->jalur_pendaftaran->biaya_seragam,
                'tagihan_seragam' => $identitas->jalur_pendaftaran->biaya_seragam,
                'identitas_id' => $identitas->id,
            ]);
            $duseragam = DUSeragam::create([
                'kode' => DUSeragam::getKode(),
                'identitas_id' => $identitas->id,
                ...$duscreden
            ]);
            $pendaftaran = Pendaftaran::create([
                'kode' => Pendaftaran::getKode(),
                'identitas_id' => $identitas->id
            ]);

            $redir = $isadmin ? '/admin/peserta' : '/';

            if (!$isadmin) {
                session([
                    'pasca_pendaftaran' => true,
                    'kode' => $pendaftaran->kode,
                    'tagihan' => $tagihan->biaya_pendaftaran
                ]);
            }
            
            return redirect($redir)->withErrors([
                'alerts' => ['success' => 'Pendaftaran berhasil.'],
            ]);
            
        } catch (\Exception $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['error' => 'Maaf, terjadi kesalahan saat memproses data.']
            ])->withInput($creden);

        }
            
    }

    public function edit(Identitas $identitas)
    {
        return view('admin.pages.forms', [
            'page' => ['title' => 'Edit Data Pendaftaran'],
            'data' => $identitas,
            'form' => [
                'action' => '/admin/edit/'.$identitas->id,
                'button' => [
                    'variant' => 'btn-warning text-white',
                    'content' => '<i class="fa fa-pen"></i> Edit Data',
                ],
                'inputs' => $this->getAdvancedFormInputs($identitas)
            ],
        ]);
    }

    private function resetTagihan (Identitas $identitas, $type) :int
    {
        $jalur = $identitas->jalur_pendaftaran;
        $tagihan = $identitas->tagihan;
        $newbiaya = $jalur["biaya_$type"];
        $oldbiaya = $tagihan["biaya_$type"];
        $oldtagihan = $tagihan["tagihan_$type"];

        $bayar = $oldbiaya - $oldtagihan;
        return $newbiaya - $bayar <= 0 ? 0 : $newbiaya - $bayar;
    }

    public function update(Request $req, Identitas $identitas)
    {

        $creden = $req->validate(Identitas::getValidations($this->admValidations));
        $duscreden = $req->validate(DUSeragam::getValidations($this->duseragamValidations));
        $creden = Identitas::getSubPrestasi($creden);
        $alerts = [];

        try {
    
            if (strtolower($creden['nama_jurusan']) !== strtolower($identitas->nama_jurusan) && $identitas->jurusan) {
                $identitas->jurusan->delete();
                $newjurusan = Jurusan::new($creden['nama_jurusan']);
                // dd($newjurusan);
                Jurusan::create([
                    ...$newjurusan,
                    'identitas_id' => $identitas->id
                ]);
                $alerts['warning'] = 'Kode jurusan peserta berubah dan yang lama tidak bisa dipakai lagi.';
            }

            $jpid = $identitas->jalur_pendaftaran_id;
            $identitas->update($creden);
            $identitas->duseragam->update($duscreden);
            
            $newbayar = [
                'pendaftaran' => Pembayaran::getBayar($identitas->tagihan->pembayarans, 'pendaftaran'),
                'daftar_ulang' => Pembayaran::getBayar($identitas->tagihan->pembayarans, 'daftar_ulang'),
                'seragam' => Pembayaran::getBayar($identitas->tagihan->pembayarans, 'seragam'),
            ];

            $newtagihan = [
                'pendaftaran' => $this->resetTagihan($identitas, 'pendaftaran') - $newbayar['pendaftaran'],
                'daftar_ulang' => $this->resetTagihan($identitas, 'daftar_ulang') - $newbayar['daftar_ulang'],
                'seragam' => $this->resetTagihan($identitas, 'seragam') - $newbayar['seragam'],
            ];
            
            foreach ($newtagihan as $type => $item) $newtagihan[$type] = $item <= 0 ? 0 : $item;

            if ($creden['jalur_pendaftaran_id'] != $jpid) {
                $identitas->tagihan->update([
                    'biaya_pendaftaran' => $identitas->jalur_pendaftaran->biaya_pendaftaran,
                    'tagihan_pendaftaran' => $newtagihan['pendaftaran'],
                    'admin_pendaftaran' => null,
                    'lunas_pendaftaran' => $newtagihan['pendaftaran'] <= 0 ? true : false,

                    'biaya_daftar_ulang' => $identitas->jalur_pendaftaran->biaya_daftar_ulang,
                    'tagihan_daftar_ulang' => $newtagihan['daftar_ulang'],
                    'admin_daftar_ulang' => null,
                    'lunas_daftar_ulang' => $newtagihan['daftar_ulang'] <= 0 ? true : false,

                    'biaya_seragam' => $identitas->jalur_pendaftaran->biaya_seragam,
                    'tagihan_seragam' => $newtagihan['seragam'],
                    'admin_seragam' => null,
                    'lunas_seragam' => $newtagihan['seragam'] <= 0 ? true : false,
                ]);
                $identitas->update([
                    'reset' => true,
                    'old_status_id' => $identitas->status_id,
                    'status_id' => 1,
                ]);
                $alerts['warning'] = 'Data peserta kembali semula pasca pendaftaran karena perubahan jalur pendaftaran.';
            }

            return redirect('/admin/peserta')->withErrors([
                'alerts' => [
                    'success' => 'Data peserta berhasil diubah.',
                    ...$alerts
                ]
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memperbarui data. Mohon hubungi penyedia layanan untuk pengembangan.']
            ])->withInput($creden);
        }

    }
    
}
