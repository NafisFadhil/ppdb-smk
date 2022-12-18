<?php

namespace App\Http\Controllers\Laporan;

use App\Filters\Filter;
use App\Models\Identitas;
use App\Models\JalurPendaftaran;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends LaporanController
{
    
    public function index(Request $req)
    {
        $filters = [
            ['name' => 'tahun', 'wheres' => [
                'whereRelation' => ['pendaftaran', DB::raw('YEAR(created_at)')],
            ]],
            ['name' => 'bulan', 'wheres' => [
                'whereRelation' => ['pendaftaran', DB::raw('MONTH(created_at)')],
            ]],
            ['name' => 'tanggal', 'wheres' => [
                'whereRelation' => ['pendaftaran', DB::raw('DAY(created_at)')],
            ]],
            ['name' => 'jurusan', 'wheres' => [
                'where' => ['nama_jurusan'],
            ]],
            ['name' => 'jalur', 'wheres' => [
                'where' => ['jalur_pendaftaran_id'],
            ]],
            ['name' => 'search', 'variant' => 'midlike', 'wheres' => [
                'where' => ['nama_lengkap', 'LIKE'],
                'orWhere' => ['asal_sekolah', 'LIKE'],
            ]],
            ['name' => 'perPage', 'wheres' => [
                'perPage' => [],
            ]],
        ];

        $data = Filter::filter(
            Identitas::with([
                'pendaftaran', 'jurusan', 'jalur_pendaftaran'
            ])->has('jurusan')
        , $req, $filters)->paginate(
            perPage: Filter::getValue('perPage') ?? Filter::$perPage,
			page: Filter::getValue('page') ?? Filter::$page
        );

        return view('admin.pages.laporan.pendaftaran',[
            'page' => ['title' => 'Laporan Pendaftaran'],
            'type' => $req->query('type') ?? 'pendaftaran',
            'laporan' => $data,
            'filters' => [
                [
                    ['type' => 'search', 'name' => 'search', 'placeholder' => 'Cari peserta...', 'size' => 'sm'],
                ],
                [
                    ['type' => 'select', 'name' => 'jurusan', 'options' => Jurusan::getOptions()],
                    ['type' => 'select', 'name' => 'jalur', 'options' => JalurPendaftaran::getAdvancedOptions()],
                ],
                [
                    ['type' => 'select', 'name' => 'tanggal', 'options' => $this->getTanggalOptions()],
                    ['type' => 'select', 'name' => 'bulan', 'options' => $this->getBulanOptions()],
                    ['type' => 'select', 'name' => 'tahun', 'options' => $this->getTahunOptions()],

                    ['type' => 'select', 'name' => 'perPage', 'options' => [
                        ['label' => '-- Per Page --', 'value' => ''],
                        5,10,15,20,25,50,100
                    ]],
                ]
            ],
        ]);
    }

    public function cetak ()
    {
        $type = request('type');
        if (!$type) return back()->withErrors([
            'alerts' => ['danger' => 'Invalid request.']
        ]);

        return view('admin.pages.cetak.pendaftaran', [
            'title' => 'Laporan Pendaftaran',
            'laporan' => Identitas::with(['pendaftaran', 'jurusan', 'jalur_pendaftaran'])
                ->get()
        ]);
    }
    
}
