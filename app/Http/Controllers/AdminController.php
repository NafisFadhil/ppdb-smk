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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    
    private function getModel() {
        return Identitas::latest()->with([
            'pendaftaran', 'status', 'jenis_kelamin', 'jurusan'
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
        $data = Filter::filter($this->getModel(), $req, 'peserta', relation: '-');

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
            // 'forms' => [
            //     [
            //         [
            //             'title' => 'Data Siswa',
            //             'inputs' => [
            //                 ['attr' => 'disabled', 'name' => 'nama_lengkap', 'value' => $identitas->nama_lengkap],
            //                 ['attr' => 'disabled', 'name' => 'kode', 'value' => $identitas->jurusan->kode ?? $identitas->pendaftaran->kode ?? '-'],
            //                 ['attr' => 'disabled', 'name' => 'jalur_pendaftaran', 'value' => \App\Helpers\ModelHelper::getJalur($identitas->jalur_pendaftaran)],
            //                 ['attr' => 'disabled', 'name' => 'status', 'value' => strtoupper($identitas->status->level)],
            //             ]
            //         ],
            //         [
            //             'title' => 'Pendaftaran',
            //             'inputs' => [
            //                 ['attr' => 'disabled', 'name' => 'biaya_pendaftaran', 'value' => NumberHelper::toRupiah($tagihan->biaya_pendaftaran)],
            //                 ['attr' => 'disabled', 'name' => 'tagihan_pendaftaran', 'value' => NumberHelper::toRupiah($tagihan->tagihan_pendaftaran)],
            //                 ['attr' => 'disabled', 'name' => 'admin_pendaftaran', 'value' => $tagihan->admin_pendaftaran->name ?? $tagihan->admin_pendaftaran->username ?? '-'],
            //                 ['attr' => 'disabled', 'name' => 'status_pendaftaran', 'value' => ModelHelper::getStatusBayar($identitas->tagihan, 'pendaftaran')],
            //             ]
            //         ],
            //     ],
            //     [
            //         [
            //             'title' => 'Daftar Ulang',
            //             'inputs' => [
            //                 ['attr' => 'disabled', 'name' => 'biaya_daftar_ulang', 'value' => NumberHelper::toRupiah($tagihan->biaya_daftar_ulang)],
            //                 ['attr' => 'disabled', 'name' => 'tagihan_daftar_ulang', 'value' => NumberHelper::toRupiah($tagihan->tagihan_daftar_ulang)],
            //                 ['attr' => 'disabled', 'name' => 'admin_daftar_ulang', 'value' => $tagihan->admin_daftar_ulang->name ?? $tagihan->admin_daftar_ulang->username ?? '-'],
            //                 ['attr' => 'disabled', 'name' => 'status_daftar_ulang', 'value' => ModelHelper::getStatusBayar($identitas->tagihan, 'daftar_ulang')],
            //             ]
            //         ],
            //         [
            //             'title' => 'Seragam',
            //             'inputs' => [
            //                 ['attr' => 'disabled', 'name' => 'biaya_seragam', 'value' => NumberHelper::toRupiah($tagihan->biaya_seragam)],
            //                 ['attr' => 'disabled', 'name' => 'tagihan_seragam', 'value' => NumberHelper::toRupiah($tagihan->tagihan_seragam)],
            //                 ['attr' => 'disabled', 'name' => 'admin_seragam', 'value' => $tagihan->admin_seragam->name ?? $tagihan->admin_seragam->username ?? '-'],
            //                 ['attr' => 'disabled', 'name' => 'status_seragam', 'value' => ModelHelper::getStatusBayar($identitas->tagihan, 'seragam')],
            //             ]
            //         ],
            //     ],
            // ],
        ]);
    }

    public function pembayaran (Identitas $identitas)
    {
        return view('admin.pages.pembayaran', [
            'page' => ['title' => 'Detail Pembayaran Siswa'],
            'data' => $identitas
        ]);
    }

    public function hapus(Identitas $identitas)
    {
        try {
            if ($identitas->tagihan) {
                $identitas->tagihan->delete();
            } if ($identitas->pendaftaran) {
                $identitas->pendaftaran->delete();
            } if ($identitas->duseragam) {
                $identitas->duseragam->delete();
            } if ($identitas->duseragam) {
                $identitas->duseragam->delete();
            } if ($identitas->sponsorship) {
                $identitas->sponsorship->delete();
            } if ($identitas->user) {
                $identitas->user->delete();
            } $identitas->delete();
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
