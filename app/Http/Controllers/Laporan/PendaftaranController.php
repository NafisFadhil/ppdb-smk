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

        $type = $req->query('type') ?? 'pendaftaran';
        $filters = $this->getFilters([
            'search',
            'jurusan',
            'jalur',
            'tanggal',
            'bulan',
            'tahun',
            'perPage',
        ]);

        $data = Filter::filter(
            Identitas::with([
                'pendaftaran', 'jurusan', 'jalur_pendaftaran'
            ])->has('jurusan')
        , $req, $filters)->paginate(
            perPage: Filter::getValue('perPage') ?? Filter::$perPage,
			page: Filter::getValue('page') ?? Filter::$page
        );

        return view('layouts.laporan',[
            'page' => ['title' => 'Laporan Pendaftaran'],
            'type' => $type,
            'laporan' => $data,
            'filters' => [
                [
                    ['type' => 'search', 'name' => 'search', 'placeholder' => 'Cari peserta...'],
                ],
                [
                    ['type' => 'select', 'name' => 'type', 'value' => $type, 'options' => $this->getTypeOptions()],
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

        return view('layouts.cetak-laporan', [
            'title' => 'Laporan Pendaftaran',
            'type' => $type,
            'laporan' => Identitas::with(['pendaftaran', 'jurusan', 'jalur_pendaftaran'])
                ->get()
        ]);
    }
    
}
