<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Filters\Filter;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Identitas;
use App\Models\JalurPendaftaran;
use App\Models\Jurusan;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;



class LaporanController extends Controller
{
    
    protected Builder $model;

    protected array $filters;

    protected function getModel ($bigtype, $type)
    {
        $model = Identitas::with([
            'pendaftaran', 'jurusan', 'jalur_pendaftaran', 'tagihan'
        ]);

        if ($bigtype === 'pendaftaran') {
            return $model
            ->has('jurusan')
            ->has('pendaftaran')
            ->has('user');
        } else return $model->has('jurusan')
            ->has('jurusan')
            ->has('pendaftaran')
            ->has('user')
            ->has('duseragam')
            ->has('tagihan');
    }
    
    public function index(Request $req, $bigtype)
    {
        $bigtype = Str::slug($bigtype, '_');
        $type = $req->query('type') ?? $bigtype;
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
            $this->getModel($bigtype, $type)
        , $req, $filters)->paginate(
            perPage: Filter::getValue('perPage') ?? Filter::$perPage,
			page: Filter::getValue('page') ?? Filter::$page
        );

        return view('layouts.laporan',[
            'page' => ['title' => 'Laporan ' . Str::title(str_replace('_', ' ', $bigtype))],
            'type' => $type,
            'bigtype' => $bigtype,
            'laporan' => $data,
            'filters' => [
                [
                    ['type' => 'search', 'name' => 'search', 'placeholder' => 'Cari peserta...'],
                ],
                [
                    ['type' => 'select', 'name' => 'type', 'value' => $type, 'options' => $this->getTypeOptions($bigtype)],
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

    public function cetak ($bigtype)
    {
        $bigtype = Str::slug($bigtype, '_');
        $type = request('type');
        
        if (!$type) return back()->withErrors([
            'alerts' => ['danger' => 'Invalid request.']
        ]);

        return view('layouts.cetak-laporan', [
            'title' => 'Laporan ' . Str::title(str_replace('_', ' ', $bigtype)),
            'type' => $type,
            'bigtype' => $bigtype,
            'laporan' => $this->getModel($bigtype, $type)->get()
        ]);
    }
    
    protected function initFilters () :void
    {
        $this->filters = [
            'tahun' => [
                'wheres' => [
                    'whereRelation' => ['pendaftaran', DB::raw('YEAR(created_at)')],
                ]
            ],
            'bulan' => [
                'wheres' => [
                    'whereRelation' => ['pendaftaran', DB::raw('MONTH(created_at)')],
                ]
            ],
            'tanggal' => [
                'wheres' => [
                    'whereRelation' => ['pendaftaran', DB::raw('DAY(created_at)')],
                ]
            ],
            'jurusan' => [
                'wheres' => [
                    'where' => ['nama_jurusan'],
                ]
            ],
            'jalur' => [
                'wheres' => [
                    'where' => ['jalur_pendaftaran_id'],
                ]
            ],
            'search' => [
                'variant' => 'midlike',
                'wheres' => [
                    'where' => ['nama_lengkap', 'LIKE'],
                    'orWhere' => ['asal_sekolah', 'LIKE'],
                ]
            ],
            'perPage' => ['wheres' => ['perPage' => []]],
        ];
    }

    protected function getFilters (array $names) :array
    {
        $this->initFilters();
        $filters = [];
        foreach ($names as $name) {
            if (array_key_exists($name, $this->filters)) {
                $filters[] = ['name' => $name, ...$this->filters[$name]];
            }
        }
        return $filters;
    }

    protected function getTahunOptions () :array
    {
        return [
            ['label' => '-- Pilih Tahun --', 'value' => ''],
            '2022', '2023', '2024'
        ];
    }

    protected function getBulanOptions () :array
    {
        $iter = 1;
        return [
            ['label' => '-- Pilih Bulan --', 'value' => ''],
            ['label' => 'Januari', 'value' => $iter++],
            ['label' => 'Februari', 'value' => $iter++],
            ['label' => 'Maret', 'value' => $iter++],
            ['label' => 'April', 'value' => $iter++],
            ['label' => 'Mei', 'value' => $iter++],
            ['label' => 'Juni', 'value' => $iter++],
            ['label' => 'Juli', 'value' => $iter++],
            ['label' => 'Agustus', 'value' => $iter++],
            ['label' => 'September', 'value' => $iter++],
            ['label' => 'Oktober', 'value' => $iter++],
            ['label' => 'November', 'value' => $iter++],
            ['label' => 'Desember', 'value' => $iter++],
        ];
    }

    protected function getTanggalOptions () :array
    {
        $opts = [['label' => '-- Pilih Tanggal --', 'value' => '']];
        for ($i = 1; $i <= 33; $i++) {
            $opts[] = $i;
        } return $opts;
    }

    protected function getTypeOptions ($bigtype) :array
    {
        return [
            ['label' => '-- Pilih Laporan --', 'value' => ''],
            ['label' => Str::title(str_replace('_', ' ', $bigtype)), 'value' => $bigtype],
            ['label' => 'Pembayaran', 'value' => 'pembayaran'],
        ];
    }

}
