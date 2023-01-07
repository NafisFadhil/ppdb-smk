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
use App\Strainer\Strain;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;



class LaporanController extends Controller
{
    
    protected Builder $model;

    protected Strain $strain;

    protected array $filters;


    protected function getModel ($bigtype) {
        $model = Identitas::withTrashed()
        ->with([
            'jurusan', 'jalur_pendaftaran', 'jenis_kelamin',
            'tagihan', 'verifikasi', 'status', 'sponsorship'
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
            ->whereRelation('verifikasi', 'pendaftaran', true)
            ->whereRelation('verifikasi', 'identitas', true);
        } elseif ($bigtype === 'sponsorship') {
            return $model
            ->whereRelation('verifikasi', 'sponsorship', true)
            ->has('sponsorship');
        }
    }

    protected function getPreModel ($bigtype) {
        $model = Identitas::withTrashed()
        ->with([
            'jurusan', 'jalur_pendaftaran', 'jenis_kelamin',
            'tagihan', 'verifikasi', 'status', 'sponsorship'
        ]);
        
        if ($bigtype === 'pendaftaran') {
            return $model;
            // ->whereRelation('verifikasi', 'pendaftaran', true);
        } elseif ($bigtype === 'daftar_ulang') {
            return $model
            ->whereRelation('verifikasi', 'pendaftaran', true);
            // ->whereRelation('verifikasi', 'daftar_ulang', true);
        } elseif ($bigtype === 'seragam') {
            return $model
            ->whereRelation('verifikasi', 'pendaftaran', true);
            // ->whereRelation('verifikasi', 'seragam', true);
        } elseif ($bigtype === 'pendataan') {
            return $model
            ->whereRelation('verifikasi', 'pendaftaran', true);
        } elseif ($bigtype === 'sponsorship') {
            return $model
            // ->whereRelation('verifikasi', 'pendaftaran', true)
            ->has('sponsorship');
        }
    }

    protected function getSubQuery (\Illuminate\Database\Query\Builder $subquery, string $bigtype) {
        $subquery = $subquery->whereNull('identitas.deleted_at');
        
        if ($bigtype === 'pendaftaran') {
            return $subquery->where('verifikasi.pendaftaran', true);
        } elseif ($bigtype === 'daftar_ulang') {
            return $subquery;
            // ->whereRelation('verifikasi', 'pendaftaran', true);
        } elseif ($bigtype === 'seragam') {
            return $subquery;
            // ->whereRelation('verifikasi', 'pendaftaran', true);
        } elseif ($bigtype === 'pendataan') {
            return $subquery;
            // ->whereRelation('verifikasi', 'pendaftaran', true);
        } elseif ($bigtype === 'sponsorship') {
            return $subquery;
            // ->has('sponsorship');
        }
    }

    protected function getPreSubQuery (\Illuminate\Database\Query\Builder $subquery, string $bigtype) {
        if ($bigtype === 'pendaftaran') {
            return $subquery->where('verifikasi.pendaftaran', true);
        } elseif ($bigtype === 'daftar_ulang') {
            return $subquery->where('verifikasi.pendaftaran', true);
        } elseif ($bigtype === 'seragam') {
            return $subquery->where('verifikasi.pendaftaran', true);
        } elseif ($bigtype === 'pendataan') {
            return $subquery->where('verifikasi.pendaftaran', true);
        } elseif ($bigtype === 'sponsorship') {
            return $subquery->whereExists(function ($query) {
                $query->select(DB::raw(1))->from('sponsorship')
                    ->whereColumn('sponsorship.identitas_id', 'identitas.id');
            });
        }
    }

    public function index(Request $req, $bigtype)
    {
        $bigtype = Str::slug($bigtype, '_');
        $type = $req->query('type') ?? $bigtype;
        $title_type = $type == $bigtype ? '' : ' '.ucfirst($type);
        $title_bigtype = Str::title(str_replace('_', ' ', $bigtype));

        $with_subquery = in_array($bigtype, ['pendaftaran', 'seragam', 'daftar_ulang']);

        // $data = $this->getModel($bigtype);
        $strain = $this->strain = new Strain($this->getModel($bigtype), $req, [
            'suptype' => 'laporan',
            'type' => $bigtype,
            'subtype' => $type,
            'with_subquery' => $with_subquery
        ]);

        if ($with_subquery) {
            $strain->subquery = $this->getSubQuery($strain->subquery, $bigtype);
        }

        return view('admin.pages.laporan',[
            'page' => ['title' => 'Laporan'.$title_type.' '.$title_bigtype],
            'type' => $type,
            'bigtype' => $bigtype,
            'laporan' => $strain->query,
            'subquery' => $with_subquery ? Strain::parseAssociate($strain->subquery->get()->first()) : null,
            'filters' => $strain->form_options,
        ]);
    }

    public function cetak (Request $req, $bigtype)
    {
        $bigtype = Str::slug($bigtype, '_');
        $type = $req->query('type') ?? $bigtype;
        $title_type = $type == $bigtype ? '' : ' '.ucfirst($type);
        $title_bigtype = Str::title(str_replace('_', ' ', $bigtype));
        
        $with_subquery = in_array($bigtype, ['pendaftaran', 'seragam', 'daftar_ulang']);
        
        $strain = $this->strain = new Strain($this->getPreModel($bigtype), $req, [
            'suptype' => 'laporan',
            'type' => $bigtype,
            'subtype' => $type,
            'with_subquery' => $with_subquery
        ]);

        if ($with_subquery) {
            $strain->subquery = $this->getPreSubQuery($strain->subquery, $bigtype);
        }

        return view('admin.pages.cetak', [
            'title' => 'Laporan'.$title_type.' '.$title_bigtype,
            'type' => $type,
            'bigtype' => $bigtype,
            'laporan' => $this->getModel($bigtype, $type)->get(),
            'subquery' => $with_subquery ? Strain::parseAssociate($strain->subquery->get()->first()) : null,
        ]);
    }

    public function precetak(Request $req, $prebigtype) {
        $bigtype = $prebigtype;
        $bigtype = Str::slug($bigtype, '_');
        $type = $req->query('type') ?? $bigtype;
        $title_type = $type == $bigtype ? '' : ' '.ucfirst($type);
        $title_bigtype = Str::title(str_replace('_', ' ', $bigtype));
        
        $with_subquery = in_array($bigtype, ['pendaftaran', 'seragam', 'daftar_ulang']);
        
        $strain = $this->strain = new Strain($this->getPreModel($bigtype), $req, [
            'suptype' => 'laporan',
            'type' => $bigtype,
            'subtype' => $type,
            'with_subquery' => $with_subquery
        ]);

        if ($with_subquery) {
            $strain->subquery = $this->getPreSubQuery($strain->subquery, $bigtype);
        }

        return view('admin.pages.cetak', [
            'title' => 'Laporan Lengkap'.$title_type.' '.$title_bigtype,
            'type' => $type,
            'precetak' => true,
            'bigtype' => $bigtype,
            'laporan' => $strain->query,
            'subquery' => $with_subquery ? Strain::parseAssociate($strain->subquery->get()->first()) : null,
        ]);
    }

}
