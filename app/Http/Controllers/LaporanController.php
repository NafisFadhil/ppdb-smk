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
        ])->select([
            '*',
            
            // DB::raw('SUM(tagihans.bayar) AS total_bayar'),
        ])
        ;
        
        // dd($model->get());
        // ->union(DB::query()->selectRaw('count(id) AS total_bayar')->from('tagihans')->get());
        // DB::query()->selectRaw('SUM(tagihans.bayar) AS total_bayar')->from('tagihans')->get()

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
        } elseif ($bigtype === 'sponsorship') {
            return $model
            ->whereRelation('verifikasi', 'pendaftaran', true)
            ->has('sponsorship');
        }
    }
    
    public function index(Request $req, $bigtype)
    {
        if ($req->query) {
            dd($req->all());
        }
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
            'filters' => Filter::getLaporanOptions($bigtype, $type),
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
