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
        $data = Filter::filter($this->getModel($bigtype, $type), $req);

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
                    ['type' => 'select', 'name' => 'type', 'value' => $type, 'options' => Filter::getTypeOptions($bigtype)],
                    ['type' => 'select', 'name' => 'jurusan', 'options' => Jurusan::getOptions()],
                    ['type' => 'select', 'name' => 'jalur', 'options' => JalurPendaftaran::getAdvancedOptions()],
                ],
                [
                    ['type' => 'select', 'name' => 'tanggal', 'options' => Filter::getTanggalOptions()],
                    ['type' => 'select', 'name' => 'bulan', 'options' => Filter::getBulanOptions()],
                    ['type' => 'select', 'name' => 'tahun', 'options' => Filter::getTahunOptions()],

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

}
