<?php

namespace App\Filters;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

trait FilterOptions
{
	use FilterAttributes;

	public static function getFilters (array $filters, array|null $names = null) :array
    {
		$names = is_null($names) ? static::getDefaultFilterNames() : $names;
        static::initFilters($filters); // Replace recursive
        $newfilters = [];
		
        foreach ($names as $name) {
            if (array_key_exists($name, static::$filters)) {
                $newfilters[] = ['name' => $name, ...static::$filters[$name]];
            }
        }
        return $newfilters;
    }

	public static function getDefaultFilterNames () :array
	{
		return [
            'search',
            'jurusan',
            'jalur',
            'tanggal',
            'bulan',
            'tahun',
            'perPage',
        ];
	}

	protected static function initFilters (array $usrfilter = []) :array
    {
        return static::$filters = array_replace_recursive([
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
        ], $usrfilter);
    }
	
	public static function getTahunOptions () :array
    {
        return [
            ['label' => '-- Pilih Tahun --', 'value' => ''],
            '2022', '2023', '2024'
        ];
    }

    public static function getBulanOptions () :array
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

    public static function getTanggalOptions () :array
    {
        $opts = [['label' => '-- Pilih Tanggal --', 'value' => '']];
        for ($i = 1; $i <= 33; $i++) {
            $opts[] = $i;
        } return $opts;
    }

    public static function getTypeOptions ($bigtype) :array
    {
        return [
            ['label' => '-- Pilih Laporan --', 'value' => ''],
            ['label' => Str::title(str_replace('_', ' ', $bigtype)), 'value' => $bigtype],
            ['label' => 'Pembayaran', 'value' => 'pembayaran'],
        ];
    }
	
}
