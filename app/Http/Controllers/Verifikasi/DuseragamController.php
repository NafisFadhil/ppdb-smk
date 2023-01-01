<?php

namespace App\Http\Controllers\Verifikasi;

use App\Filters\Filter;
use App\Filters\FilterOptions;
use App\Helpers\ModelHelper;
use App\Http\Controllers\Controller;
use App\Models\DataJalurPendaftaran;
use App\Models\Identitas;
use App\Models\Jurusan;
use App\Models\Pembayaran;
use App\Models\Seragam;
use App\Validations\PembayaranValidation;
use App\Validations\SeragamValidation;
use App\Validations\TagihanValidation;
use Illuminate\Http\Request;

class DuseragamController extends Controller
{
    private function getModel() {
        return Identitas::with([
            'daftar_ulang', 'status', 'jenis_kelamin', 'jurusan', 'tagihan', 'verifikasi'
        ])
        ->whereRelation('verifikasi', 'pendaftaran', true)
        ->whereRelation('status', 'level', 'daftar ulang & seragam');
    }
    
    public function index(Request $req)
	{
        session(['oldpath' => request()->path()]);
        $data = Filter::filter($this->getModel(), $req, 'verifikasi', 'duseragam', relation: '-');

        return view('admin.pages.table', [
            'page' => ['title' => 'Verifikasi DU & Seragam'],
            'table' => 'verifikasi-duseragam',
            'peserta' => $data,
            'options' => [
                'seragam_olahraga' => Seragam::getOptions('olahraga'),
                'seragam_wearpack' => Seragam::getOptions('wearpack'),
                'seragam_almamater' => Seragam::getOptions('almamater'),
            ],
            'filters' => FilterOptions::getVerifikasiFormOptions('duseragam')
        ]);
	}

    public function biaya(Request $req, Identitas $identitas)
    {
        // Initiation Credentials
        $tagihan_creden = $req->validate(TagihanValidation::getValidations([
            'biaya_daftar_ulang', 'biaya_seragam'
        ]));
        $seragam_creden = $req->validate(SeragamValidation::getValidations([
            'ukuran_olahraga', 'ukuran_wearpack', 'ukuran_almamater'
        ]));
        $keterangan_creden = $req->validate([
            'keterangan' => 'nullable|string'
        ]);
        $daftar_ulang_creden = [];
        $identitas_creden = [];
        $alerts = [];

        try {

            // Alur Logika Tagihan Daftar Ulang
            $biaya_du = $tagihan_creden['biaya_daftar_ulang'];
            $bayar_du = ModelHelper::getBayar($identitas->tagihan->pembayaran, 'daftar_ulang');
            $kurang_du = $biaya_du - $bayar_du;
            $lunas_du = $kurang_du <= 0;

            // Mock Tagihan Daftar Ulang
            $tagihan_creden['tagihan_daftar_ulang'] = $kurang_du;
            $tagihan_creden['lunas_daftar_ulang'] = $lunas_du;
            $tagihan_creden['admin_daftar_ulang_id'] = $req->user()->id;

            if ($lunas_du) {
                $tagihan_creden['tanggal_lunas_daftar_ulang'] = now();
                $alerts['info'] = 'Pembayaran daftar ulang lunas.';
            }


            // Alur Logika Tagihan Seragam
            $biaya_seragam = $tagihan_creden['biaya_seragam'];
            $bayar_seragam = ModelHelper::getBayar($identitas->tagihan->pembayaran, 'seragam');
            $kurang_seragam = $biaya_seragam - $bayar_seragam;
            $lunas_seragam = $kurang_seragam <= 0;

            // Mock Tagihan Seragam
            $tagihan_creden['tagihan_seragam'] = $kurang_seragam;
            $tagihan_creden['lunas_seragam'] = $lunas_seragam;
            $tagihan_creden['admin_seragam_id'] = $req->user()->id;

            if ($lunas_seragam) {
                $tagihan_creden['tanggal_lunas_seragam'] = now();
                $alerts['info'] = 'Pembayaran seragam lunas.';
            }

            // Mock Identitas
            $lunas = $lunas_du && $lunas_seragam;
            $identitas_creden['status_id'] = $identitas->status_id + ($lunas ? 2 : 1);
            if ($lunas) {
                $alerts['info'] = 'Pembayaran daftar ulang dan seragam lunas.';
            }

            // Mock Keterangan
            $daftar_ulang_creden['keterangan'] = $keterangan_creden['keterangan'];
            $seragam_creden['keterangan'] = $keterangan_creden['keterangan'];

            // Queue Database Transaction
            dispatch_sync(function () use (
                $tagihan_creden, $seragam_creden, $daftar_ulang_creden,
                $identitas_creden, $identitas
            ) {
                $identitas->tagihan->update($tagihan_creden);
                $identitas->daftar_ulang->update($daftar_ulang_creden);
                $identitas->seragam->update($seragam_creden);
                if (!empty($identitas_creden)) {
                    $identitas->update($identitas_creden);
                }
            });

            $alerts['success'] = 'Input tagihan biaya du & seragam berhasil.';
            
            return back()->withErrors([ 'alerts' => $alerts ]);

        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat input tagihan du & seragam.']
            ]);
            
        }
    }

	public function pembayaran(Request $req, $type, Identitas $identitas)
	{
        // Initiation Credentials
        $pembayaran_creden = $req->validate(PembayaranValidation::getValidations([
            'bayar'
        ]));
        $tagihan_creden = [];
        $identitas_creden = [];
        $alerts = [];
        
        // Type String Formatting
        $type = str_replace('-', '_', $type);
        
        try {

            // Alur Logika Pembayaran
            $bayar = $pembayaran_creden['bayar'];
            $kurang = $identitas->tagihan['tagihan_'.$type] - $bayar;
            $lunas = $kurang <= 0;
            
            // Mock Pembayaran
            $pembayaran_creden['type'] = $type;
            $pembayaran_creden['kurang'] = $kurang;
            $pembayaran_creden['admin_id'] = $req->user()->id;
            $pembayaran_creden['tagihan_id'] = $identitas->tagihan->id;
            
            // Mock Tagihan
            $tagihan_creden['lunas_'.$type] = $lunas;
            $tagihan_creden['tagihan_'.$type] = $kurang;
            
            if ($lunas) {
                $tagihan_creden['tanggal_lunas_'.$type] = now();
                $alerts['info'] = 'Pembayaran lunas.';
            }

            // Queue Database Transaction
            dispatch_sync(function () use (
                $pembayaran_creden, $tagihan_creden, $identitas_creden,
                $identitas
            ) {
                $identitas->tagihan->pembayarans()->create($pembayaran_creden);
                $identitas->tagihan->update($tagihan_creden);
                if (!empty($identitas_creden)) {
                    $identitas->update($identitas_creden);
                }
            });
            
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
    
	public function verifikasi(Request $req, $type, Identitas $identitas)
	{
        // Initiation Credentials
        $verifikasi_creden = [];
        $identitas_creden = [];
        $alerts = [];

        // Type String Formatting
        $type = str_replace('-', '_', $type);
        $invert_type = $type == 'seragam' ? 'daftar_ulang' : 'seragam';

        try {
            
            // Cross Checking
            $lulus = $identitas->verifikasi->$invert_type && true;
            
            // Mock Verifikasi
            $verifikasi_creden[$type] = true;
            $verifikasi_creden["tanggal_${type}"] = now();
            $verifikasi_creden["admin_${type}_id"] = $req->user()->id;

            // Mock Identitas
            if ($lulus) {
                $plus = 1;
                if ($identitas->verifikasi->identitas) {
                    $plus += 1;
                    $alerts['info'] = 'Verifikasi daftar ulang dan seragam lengkap dan sudah verifikasi pendataan.';
                } else $alerts['info'] = 'Verifikasi daftar ulang dan seragam lengkap.';

                $identitas_creden['status_id'] = $identitas->status_id + $plus;
            }

            // Queue Database Transaction
            dispatch_sync(function () use (
                $verifikasi_creden, $identitas_creden, $identitas
            ) {
                $identitas->verifikasi->update($verifikasi_creden);
                if (!empty($identitas_creden)) {
                    $identitas->update($identitas_creden);
                }
            });

            $alerts['success'] = 'Verifikasi berhasil.';

            return back()->withErrors([ 'alerts' => $alerts ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memverifikasi data.']
            ]);
        }
	}
}
