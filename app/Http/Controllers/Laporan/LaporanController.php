<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LaporanController extends Controller
{

    protected Builder $model;

    protected array $filters;
    
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

    protected function getTypeOptions () :array
    {
        return [
            ['label' => '-- Pilih Laporan --', 'value' => ''],
            ['label' => 'Pendaftaran', 'value' => 'pendaftaran'],
            ['label' => 'Pembayaran', 'value' => 'pembayaran'],
        ];
    }

}
