<?php

namespace App\Http\Controllers\Verifikasi;

use App\Filters\Filter;
use App\Filters\FilterOptions;
use App\Helpers\ModelHelper;
use App\Http\Controllers\Controller;
use App\Models\DataJalurPendaftaran;
use App\Models\Identitas;
use App\Models\Jurusan;
use App\Models\User;
use App\Validations\PembayaranValidation;
use App\Validations\PendaftaranValidation;
use App\Validations\TagihanValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PendaftaranController extends Controller
{
    private function getModel() {
        return Identitas::with([
            'pendaftaran', 'status', 'jenis_kelamin', 'jurusan', 'tagihan', 'verifikasi', 'sponsorship'
        ])->whereRelation('verifikasi', 'pendaftaran', false);
    }

    public function index (Request $req)
    {
        session(['oldpath' => request()->path()]);
        $data = Filter::filter($this->getModel(), $req, 'verifikasi', 'pendaftaran');
        
        return view('admin.pages.tverifikasi', [
            'page' => ['title' => 'Verifikasi Pendaftaran'],
            'type' => 'pendaftaran',
            'table' => 'pendaftaran',
            'peserta' => $data,
            'filters' => FilterOptions::getVerifikasiFormOptions('pendaftaran')
        ]);
    }

    public function biaya (Request $req, Identitas $identitas)
    {
        // Initiation Credentials
        $pendaftaran_creden = $req->validate(
            PendaftaranValidation::getValidations(['keterangan'])
        );
        $tagihan_creden = $req->validate(
            TagihanValidation::getValidations(['biaya_pendaftaran'])
        );
        $identitas_creden = [];
        $alerts = [];
        
        try {

            // ALur Logika Tagihan
            $biaya = $tagihan_creden['biaya_pendaftaran'];
            $bayar = ModelHelper::getBayar($identitas->tagihan->pembayaran, 'pendaftaran');
            $kurang = $biaya - $bayar;
            $lunas = $kurang <= 0;

            // Mock Identitas
            $identitas_creden['status_id'] = $identitas->status_id + ($lunas ? 2 : 1);
            
            // Mock Tagihan
            $tagihan_creden['tagihan_pendaftaran'] = $kurang;
            $tagihan_creden['lunas_pendaftaran'] = $lunas;
            $tagihan_creden['admin_pendaftaran_id'] = $req->user()->id;

            if ($lunas) {
                $pembayaran_creden = [
                    'type' => 'pendaftaran',
                    'bayar' => 0,
                    'kurang' => 0,
                    'admin_id' => $req->user()->id,
                    'tagihan_id' => $identitas->tagihan->id,
                    'identitas_id' => $identitas->id
                ];
                $identitas->tagihan->pembayarans()->create($pembayaran_creden);
                $tagihan_creden['tanggal_lunas_pendaftaran'] = now();
                $alerts['info'] = 'Pembayaran lunas.';
            }
            
            // Queue Database Transaction
            $identitas->tagihan->update($tagihan_creden);
            $identitas->pendaftaran->update($pendaftaran_creden);
            $identitas->update($identitas_creden);

            $alerts['success'] = 'Verifikasi tagihan biaya pendaftaran berhasil.';

            return back()->withErrors([
                'alerts' => $alerts
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat menginput biaya pendaftaran.']
            ]);
            
        }
    }

    public function pembayaran (Request $req, Identitas $identitas)
    {
        // Initation Credentials
        $pembayaran_creden = $req->validate(
            PembayaranValidation::getValidations(['bayar'])
        );
        $tagihan_creden = [];
        $identitas_creden = [];
        $alerts = [];
        
        try {
            
            // Alur Logika Pembayaran
            $bayar = $pembayaran_creden['bayar'];
            $kurang = $identitas->tagihan->tagihan_pendaftaran - $bayar;
            $lunas = $kurang <= 0;
            $lebih = $bayar > $kurang;

            // Mock Pembayaran
            $pembayaran_creden['type'] = 'pendaftaran';
            $pembayaran_creden['kurang'] = $kurang;
            $pembayaran_creden['admin_id'] = $req->user()->id;
            $pembayaran_creden['tagihan_id'] = $identitas->tagihan->id;
            $pembayaran_creden['identitas_id'] = $identitas->tagihan->id;
            
            // Mock Tagihan
            $tagihan_creden['lunas_pendaftaran'] = $lunas;
            $tagihan_creden['tagihan_pendaftaran'] = $kurang;
            
            if ($lunas) {
                $identitas_creden['status_id'] = $identitas->status_id + 1;
                $tagihan_creden['tanggal_lunas_pendaftaran'] = now();
                $alerts['info'] = 'Pembayaran lunas.';
            }

            // Queue Database Transaction
            $identitas->tagihan->pembayarans()->create($pembayaran_creden);
            $identitas->tagihan->update($tagihan_creden);
            if (!empty($identitas_creden)) {
                $identitas->update($identitas_creden);
            }
            
            
            $alerts['success'] = 'Input pembayaran berhasil.';

            return back()->withErrors([
                'alerts' => $alerts
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat menginput pembayaran.']
            ]);
            
        }
    }

    public function verifikasi(Request $req, Identitas $identitas)
    {
        // Initation Credentials
        $identitas_creden = [];
        $jurusan_creden = [];
        $verifikasi_creden = [];
        $daftar_ulang_creden = [];
        $user_creden = [];
        $alerts = [];

        try {
            
            // Mock Verifikasi
            $verifikasi_creden = [
                'pendaftaran' => true,
                'tanggal_pendaftaran' => now(),
                'admin_pendaftaran_id' => $req->user()->id,
            ];

            // Mock Daftar Ulang
            $daftar_ulang_creden['identitas_id'] = $identitas->id;
            
            // Mock Seragam
            $seragam_creden['identitas_id'] = $identitas->id;
            
            // Mock Identitas
            $identitas_creden['status_id'] = $identitas->status_id + 1;

            // Queue Database Transaction
            $identitas->verifikasi->update($verifikasi_creden);
            $identitas->daftar_ulang()->create($daftar_ulang_creden);
            $identitas->seragam()->create($seragam_creden);
            $identitas->update($identitas_creden);
            
            dispatch(function () use ($identitas, $user_creden) {
                $model = Jurusan::withTrashed()->select('nomor')->whereNotNull('nomor')
                ->where('singkatan', $identitas->jurusan->singkatan)->orderBy('nomor', 'DESC')->limit(1)->get()->first();

                if (!$model) $nomor = 1;
                else $nomor = $model->nomor + 1;

                $jurusan = Jurusan::getJurusan(strtolower($identitas->jurusan->singkatan));
                $kode = $jurusan->kode;

                $xnomor = str_pad($nomor, 3, '0', STR_PAD_LEFT);
                $kode = $kode.'-'.$xnomor;

                // Mock User
                $identitas->user()->create([
                    'name' => $identitas->nama_lengkap,
                    'username' => $kode,
                    'password' => Hash::make(date_format($identitas->tanggal_lahir, 'd-m-Y')),
                    'identitas_id' => $identitas->id,
                ]);

                $identitas->jurusan->update([
                    'kode' => $kode,
                    'nomor' => $nomor
                ]);
            });

            $alerts['success'] = 'Verifikasi pendaftaran berhasil.';
            
            return back()->withErrors([
                'alerts' => $alerts
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memverifikasi data.']
            ]);
        }
    }
}
