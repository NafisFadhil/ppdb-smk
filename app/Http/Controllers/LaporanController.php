<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Filters\Filter;
use App\Models\DataJalurPendaftaran;
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

    protected function getModel ($bigtype)
    {
        $model = Identitas::withTrashed()->with([
            'jurusan', 'jalur_pendaftaran', 'jenis_kelamin', 'tagihan',
            'verifikasi', 'status'
        ]);

        if ($bigtype === 'pendaftaran') {
            return $model
            ->whereRelation('verifikasi', 'pendaftaran', true);
        } elseif ($bigtype === 'daftar_ulang') {
            return $model
            ->whereRelation('verifikasi', 'pendaftaran', true)
            ->whereRelation('verifikasi', 'daftar_ulang', true);
        } elseif ($bigtype === 'seragam') {
            return $model
            ->whereRelation('verifikasi', 'pendaftaran', true)
            ->whereRelation('verifikasi', 'seragam', true);
        } elseif ($bigtype === 'pendataan') {
            return $model
            ->whereRelation('verifikasi', 'pendaftaran', true);
            // ->whereRelation('verifikasi', 'daftar_ulang', true);
        }
    }
    
    public function index(Request $req, $bigtype)
    {
        $bigtype = Str::slug($bigtype, '_');
        $type = $req->query('type') ?? $bigtype;
        $data = Filter::filter($this->getModel($bigtype), $req);
        $title_type = $type == $bigtype ? '' : ' '.ucfirst($type);
        $title_bigtype = Str::title(str_replace('_', ' ', $bigtype));

        return view('admin.pages.laporan',[
            'page' => ['title' => 'Laporan'.$title_type.' '.$title_bigtype],
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
                    ['type' => 'select', 'name' => 'jalur', 'options' => DataJalurPendaftaran::getAdvancedOptions()],
                ],
                [
                    ['type' => 'select', 'name' => 'tanggal', 'options' => Filter::getTanggalOptions()],
                    ['type' => 'select', 'name' => 'bulan', 'options' => Filter::getBulanOptions()],
                    ['type' => 'select', 'name' => 'tahun', 'options' => Filter::getTahunOptions()],

                    // ['type' => 'daterange', 'name' => 'periode'],

                    ['type' => 'select', 'name' => 'perPage', 'options' => [
                        ['label' => '-- Per Page --', 'value' => ''],
                        5,10,15,20,25,50,100
                    ]],
                ]
            ],
        ]);
    }

    public function cetak (Request $req, $bigtype)
    {
        $bigtype = Str::slug($bigtype, '_');
        $type = $req->query('type') ?? $bigtype;
        $title_type = $type == $bigtype ? '' : ' '.ucfirst($type);
        $title_bigtype = Str::title(str_replace('_', ' ', $bigtype));
        
        if (!$type) return back()->withErrors([
            'alerts' => ['danger' => 'Invalid request.']
        ]);

        return view('admin.pages.cetak', [
            'title' => 'Laporan'.$title_type.' '.$title_bigtype,
            'type' => $type,
            'bigtype' => $bigtype,
            'laporan' => $this->getModel($bigtype, $type)->get()
        ]);
    }

}
