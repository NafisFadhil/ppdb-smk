<?php

namespace App\Http\Controllers;

use App\Helpers\NumberHelper;
use App\Helpers\StringHelper;
use App\Models\DataJurusan;
use App\Models\Identitas;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function index()
    {
        // array_merge()
        return view('admin.pages.index', [
            'page' => ['title' => 'Dashboard Admin PPDB'],
            'peserta' => Identitas::select('status_id', 'nama_jurusan')->get(),
            'jurusanCounters' => Jurusan::getWidget()
        ]);
    }

    public function peserta()
    {
        $search = request('search') ?? false;
        if ($search) {
            $peserta = Identitas::where('nama_lengkap', 'like', "%$search%")
                ->latest()->paginate(25);
        } else $peserta = Identitas::latest()->with(['pendaftaran', 'user', 'status'])->paginate();

        // dd($peserta->first()->jalur_pendaftaran);

        return view('admin.pages.peserta', [
            'page' => ['title' => 'Daftar Peserta'],
            'peserta' => $peserta
        ]);
    }
    
    public function tagihan(Identitas $identitas)
    {
        $tagihan = $identitas->tagihan;

        return view('admin.pages.tagihan', [
            'page' => ['title' => 'Detail Data Tagihan'],
            'forms' => [
                [
                    [
                        'title' => 'Data Siswa',
                        'inputs' => [
                            ['attr' => 'disabled', 'name' => 'nama_lengkap', 'value' => $identitas->nama_lengkap],
                            ['attr' => 'disabled', 'name' => 'kode_jurusan', 'value' => $identitas->pendaftaran->kode],
                            ['attr' => 'disabled', 'name' => 'jalur_pendaftaran', 'value' => \App\Helpers\ModelHelper::getJalur($identitas->jalur_pendaftaran)],
                            ['attr' => 'disabled', 'name' => 'status', 'value' => strtoupper($identitas->status->level)],
                        ]
                    ],
                    [
                        'title' => 'Pendaftaran',
                        'inputs' => [
                            ['attr' => 'disabled', 'name' => 'biaya_pendaftaran', 'value' => NumberHelper::toRupiah($tagihan->biaya_pendaftaran)],
                            ['attr' => 'disabled', 'name' => 'tagihan_pendaftaran', 'value' => NumberHelper::toRupiah($tagihan->tagihan_pendaftaran)],
                            ['attr' => 'disabled', 'name' => 'admin_pendaftaran', 'value' => $tagihan->admin_pendaftaran ?? '(Belum Ada)'],
                            ['attr' => 'disabled', 'name' => 'lunas_pendaftaran', 'value' => $tagihan->lunas_pendaftaran ? 'Lunas' : 'Belum Lunas'],
                        ]
                    ],
                ],
                [
                    [
                        'title' => 'Daftar Ulang',
                        'inputs' => [
                            ['attr' => 'disabled', 'name' => 'biaya_daftar_ulang', 'value' => NumberHelper::toRupiah($tagihan->biaya_daftar_ulang)],
                            ['attr' => 'disabled', 'name' => 'tagihan_daftar_ulang', 'value' => NumberHelper::toRupiah($tagihan->tagihan_daftar_ulang)],
                            ['attr' => 'disabled', 'name' => 'admin_daftar_ulang', 'value' => $tagihan->admin_daftar_ulang ?? '(Belum Ada)'],
                            ['attr' => 'disabled', 'name' => 'lunas_daftar_ulang', 'value' => $tagihan->lunas_daftar_ulang ? 'Lunas' : 'Belum Lunas'],
                        ]
                    ],
                    [
                        'title' => 'Seragam',
                        'inputs' => [
                            ['attr' => 'disabled', 'name' => 'biaya_seragam', 'value' => NumberHelper::toRupiah($tagihan->biaya_seragam)],
                            ['attr' => 'disabled', 'name' => 'tagihan_seragam', 'value' => NumberHelper::toRupiah($tagihan->tagihan_seragam)],
                            ['attr' => 'disabled', 'name' => 'admin_seragam', 'value' => $tagihan->admin_seragam ?? '(Belum Ada)'],
                            ['attr' => 'disabled', 'name' => 'lunas_seragam', 'value' => $tagihan->lunas_seragam ? 'Lunas' : 'Belum Lunas'],
                        ]
                    ],
                ],
            ],
        ]);
    }

    public function pembayaran (Identitas $identitas)
    {
        $tagihan = $identitas->tagihan;
        $pembayarans = $tagihan->pembayarans;
        $type = request('type') ?? null;
        $iter = 0; $cards = [];
        foreach ($pembayarans as $row) {
            if ($type !== null && $row->type !== $type) continue;
            $iter++;
            
            $cards[] = [
                'title' => 'Pembayaran ' . $iter . ' ('  . StringHelper::toTitle($row->type) . ')',
                'inputs' => [
                    ['attr' => 'disabled', 'name' => 'bayar', 'value' => NumberHelper::toRupiah($row->bayar)],
                    ['attr' => 'disabled', 'name' => 'kurang', 'value' => NumberHelper::toRupiah($row->kurang)],
                    ['attr' => 'disabled', 'name' => 'status', 'value' => $row->kurang === 0 ? 'Lunas' : 'Belum Lunas'],
                    ['attr' => 'disabled', 'name' => 'admin', 'value' => $row->admin],
                ]
            ];
        }

        return view('admin.pages.pembayaran', [
            'page' => ['title' => 'Detail Pembayaran Siswa'],
            'forms' => [
                [
                    'title' => 'Data Siswa',
                    'inputs' => [
                        ['attr' => 'disabled', 'name' => 'nama_lengkap', 'value' => NumberHelper::toRupiah($tagihan->biaya_pendaftaran)],
                        ['attr' => 'disabled', 'name' => 'kode_jurusan', 'value' => $identitas->jurusan->kode ?? '-'],
                        ['attr' => 'disabled', 'name' => 'jalur_pendaftaran', 'value' => \App\Helpers\ModelHelper::getJalur($identitas->jalur_pendaftaran)],
                        ['attr' => 'disabled', 'name' => 'status', 'value' => $identitas->status->level],
                    ]
                ],
                ...$cards
            ],
        ]);
    }

    public function postProfil(Request $req)
    {
        
    }
    
}
