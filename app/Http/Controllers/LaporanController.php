<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Filters\Filter;
use App\Filters\FilterOptions;
use App\Models\DataJalurPendaftaran;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Identitas;
use App\Models\JalurPendaftaran;
use App\Models\Jurusan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;



class LaporanController extends Controller
{
    
    protected Builder $model;

    protected array $filters;

    protected function getModel ($bigtype) {
        $model = Identitas::withTrashed()
        ->withSum('pembayarans as total_pembayaran', 'bayar')
        ->with([
            'jurusan', 'jalur_pendaftaran', 'jenis_kelamin',
            'tagihan', 'verifikasi', 'status'
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
        } elseif ($bigtype === 'sponsorship') {
            return $model
            ->whereRelation('verifikasi', 'pendaftaran', true)
            ->has('sponsorship');
        }
    }

    // protected function getModel(string $bigtype)
    // {
    //     $model = DB::table('identitas')
    //     ->join('jurusans', 'jurusans.identitas_id', 'identitas.id')
    //     ->join('data_jalur_pendaftarans as jalur_pendaftarans', 'identitas.jalur_pendaftaran_id', 'jalur_pendaftarans.id')
    //     ->join('data_jenis_kelamins as jenis_kelamins', 'identitas.jenis_kelamin_id', 'jenis_kelamins.id')
    //     ->join('tagihans', 'tagihans.identitas_id', 'identitas.id')
    //     ->join('verifikasis', 'verifikasis.identitas_id', 'identitas.id')
    //     ->join('statuses', 'identitas.status_id', 'statuses.id');

    //     if ($bigtype === 'pendaftaran') {
    //         return $model
    //         ->whereRelation('verifikasi', 'pendaftaran', true);
    //     } elseif ($bigtype === 'daftar_ulang') {
    //         return $model
    //         ->whereRelation('verifikasi', 'pendaftaran', true)
    //         ->whereRelation('verifikasi', 'daftar_ulang', true);
    //     } elseif ($bigtype === 'seragam') {
    //         return $model
    //         ->whereRelation('verifikasi', 'pendaftaran', true)
    //         ->whereRelation('verifikasi', 'seragam', true);
    //     } elseif ($bigtype === 'pendataan') {
    //         return $model
    //         ->whereRelation('verifikasi', 'pendaftaran', true);
    //     } elseif ($bigtype === 'sponsorship') {
    //         return $model
    //         ->whereRelation('verifikasi', 'pendaftaran', true)
    //         ->has('sponsorship');
    //     }
    // }
    
    public function index(Request $req, $bigtype)
    {
        // if ($req->query->all()) dd($req->query->all());
        $bigtype = Str::slug($bigtype, '_');
        $type = $req->query('type') ?? $bigtype;
        $title_type = $type == $bigtype ? '' : ' '.ucfirst($type);
        $title_bigtype = Str::title(str_replace('_', ' ', $bigtype));

        $data = Filter::filter(
            $this->getModel($bigtype),
            $req, 'laporan', $bigtype, $type
        );
        
        return view('admin.pages.laporan',[
            'page' => ['title' => 'Laporan'.$title_type.' '.$title_bigtype],
            'type' => $type,
            'bigtype' => $bigtype,
            'laporan' => $data,
            'filters' => FilterOptions::getLaporanFormOptions($bigtype, $type),
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
