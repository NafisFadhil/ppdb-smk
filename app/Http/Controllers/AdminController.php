<?php

namespace App\Http\Controllers;

use App\Filters\Filter;
use App\Filters\FilterOptions;
use App\Helpers\ModelHelper;
use App\Helpers\NumberHelper;
use App\Helpers\StringHelper;
use App\Models\DataJalurPendaftaran;
use App\Models\DataJurusan;
use App\Models\Identitas;
use App\Models\Jurusan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    
    private function getModel() {
        return Identitas::with([
            'pendaftaran', 'status', 'jenis_kelamin', 'jurusan',
            'tagihan', 'jalur_pendaftaran', 'user'
        ]);
    }
    
    public function index()
    {
        $data = Identitas::with([
            'jurusan', 'verifikasi', 'status'
        ])->select(['id'])->get();

        return view('admin.pages.index', [
            'page' => ['title' => 'Dashboard Admin PPDB'],
            'siswa' => $data,
            'data_jurusans' => Jurusan::getJurusans()
        ]);
    }

    public function peserta(Request $req)
    {
        session(['oldpath' => request()->path()]);
        $data = Filter::filter($this->getModel(), $req, 'verifikasi', 'peserta', relation: '-');

        return view('admin.pages.table', [
            'page' => ['title' => 'Daftar Peserta PPDB'],
            'peserta' => $data,
            'table' => 'peserta',
            'filters' => FilterOptions::getVerifikasiFormOptions('peserta'),
        ]);
    }
    
    public function tagihan(Identitas $identitas)
    {
        return view('admin.pages.tagihan', [
            'page' => ['title' => 'Detail Data Tagihan'],
            'data' => $identitas
        ]);
    }

    public function pembayaran (Identitas $identitas)
    {
        return view('admin.pages.pembayaran', [
            'page' => ['title' => 'Detail Pembayaran Siswa'],
            'data' => $identitas
        ]);
    }

    public function edit_pembayaran(Identitas $identitas) {
        $type = request('type');
        $title_type = \App\Helpers\StringHelper::toTitle($type);
        $inputs = $this->getEditPembayaranFormInputs($identitas, $type);

        $button = count($inputs) > 0 ? [
            'variant' => 'warning',
            'content' => '<i class="fa fa-edit"></i> Edit Pembayaran',
        ] : [];
        
        return view('admin.pages.forms', [
            'page' => ['title' => 'Edit Data Pembayaran '.$title_type],
            'form' => [
                'variant' => 'multiform',
                'cols' => 'col-12',
                'action' => '/admin/pembayaran/edit/'.$identitas->id,
                'button' => $button,
                'inputs' => $inputs
            ],
        ]);
    }

    public function update_pembayaran (Request $req, Identitas $identitas) {
        $jumlah_bayar = $req->get('jumlah_bayar');

        $bayars = []; $pembayaran_creden = [];
        for ($i=1; $i<=$jumlah_bayar; $i++) {
            // Initiation Credentials
            $creden = $req->validate([
                'bayar_'.$i => 'required|numeric',
                'kurang_'.$i => 'required|numeric',
                'id_'.$i => 'required|numeric',
            ]);

            $pembayaran_creden = array_merge($pembayaran_creden, $creden);

            $bayars[$i] = $identitas->tagihan->pembayarans()
                ->where('id', $pembayaran_creden['id_'.$i]);
        }

        // dd($pembayaran_creden);
        $trash = $bayars[1]->get()->first();
        $type = $trash->type;
        $newtagihan = $trash->bayar + $trash->kurang;

        for ($i=1; $i<=$jumlah_bayar; $i++) {
            $bayar = $pembayaran_creden['bayar_'.$i];
            $newtagihan -= $bayar;
            $newtagihan = $newtagihan <= 0 ? 0 : $newtagihan;
            
            $bayars[$i]->update([
                'bayar' => $bayar,
                'kurang' => $newtagihan
            ]);
        }

        $identitas->tagihan->update([
            'tagihan_'.$type => $newtagihan,
            'lunas_'.$type => $newtagihan <= 0,
            'tanggal_lunas_'.$type => $newtagihan <= 0 ? now() : null
        ]);

        return back()->withErrors([
            'alerts' => ['success' => 'Nominal pembayaran berhasil diubah.']
        ]);
        
    }

    private function getEditPembayaranFormInputs (Identitas $identitas, mixed $type) {
        $i = 0;
        $inputs = [['title' => 'Data Peserta', 'inputs' => [
            ['name' => 'kode', 'value' => is_null($identitas->jurusan->kode) ? $identitas->pendaftaran->kode : $identitas->jurusan->kode, 'attr' => 'disabled'],
            ['name' => 'nama_lengkap', 'value' => $identitas->nama_lengkap, 'attr' => 'disabled'],
            ['name' => 'jenis_kelamin', 'value' => ModelHelper::getJenisKelamin($identitas->jenis_kelamin_id), 'attr' => 'disabled'],
            ['name' => 'jalur_pendaftaran', 'value' => ModelHelper::getJalur($identitas->jalur_pendaftaran), 'attr' => 'disabled'],
            ['name' => 'asal_sekolah', 'value' => $identitas->asal_sekolah, 'attr' => 'disabled'],
        ]]];

        foreach ($identitas->tagihan->pembayarans as $pembayaran) {
            if ($pembayaran->type == $type) {
                $i++;
                $inputs[] = ['title' => 'Pembayaran '.$i, 'inputs' => [
                    ['type' => 'number', 'name' => 'bayar_'.$i, 'label' => 'Bayar', 'value' => $pembayaran->bayar],
                    ['type' => 'text', 'name' => 'kurang', 'label' => 'Tagihan', 'value' => NumberHelper::toRupiah($pembayaran->kurang), 'attr' => 'disabled'],
                    ['type' => 'hidden', 'name' => 'kurang_'.$i, 'value' => $pembayaran->kurang],
                    ['type' => 'hidden', 'name' => 'id_'.$i, 'value' => $pembayaran->id],
                    ['type' => 'hidden', 'name' => 'jumlah_bayar', 'value' => $i]
                ]];
            }
        }

        if (count($inputs) === 0) $inputs[] = [
            'title' => 'Belum ada pembayaran...'
        ];
        
        return $inputs;
    }

    public function hapus(Identitas $identitas) {
        try {
            Bus::chain([
                function () use ($identitas) {
                    if ($identitas->has('tagihan')) { 
                        $identitas->tagihan()->delete();
                    }
                },
                function () use ($identitas) {
                    if ($identitas->has('pendaftaran')) { 
                        $identitas->pendaftaran()->delete();
                    }
                },
                function () use ($identitas) {
                    if ($identitas->has('daftar_ulang')) { 
                        $identitas->daftar_ulang()->delete();
                    }
                },
                function () use ($identitas) {
                    if ($identitas->has('seragam')) { 
                        $identitas->seragam()->delete();
                    }
                },
                function () use ($identitas) {
                    if ($identitas->has('duseragam')) { 
                        $identitas->duseragam()->delete();
                    }
                },
                function () use ($identitas) {
                    if ($identitas->has('sponsorship')) { 
                        $identitas->sponsorship()->delete();
                    }
                },
                function () use ($identitas) {
                    if ($identitas->has('user')) { 
                        $identitas->user()->delete();
                    }
                },
                function () use ($identitas) {
                    if ($identitas->has('verifikasi')) { 
                        $identitas->verifikasi()->delete();
                    }
                },
                function () use ($identitas) {
                    $identitas->delete();
                },
            ])->dispatch();

            return back()->withErrors([
                'alerts' => ['success' => 'Berhasil menghapus peserta.']
            ]);
            
        } catch (\Throwable $th) {
            return back()->withErrors([
                'alerts' => ['success' => 'Maaf, terjadi kesalahan saat menghapus peserta.']
            ]);
        }
    }
    
}
