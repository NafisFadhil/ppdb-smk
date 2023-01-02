<?php

namespace App\Filters;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class FilterOptions
{
	// use FilterAttributes;

	public static function getFilters () :array {
        FilterParser::parseNames();
        FilterParser::parseFilters();
        static::initFilters();

        $newfilters = [];
        foreach (Filter::$names as $name) {
            if (array_key_exists($name, Filter::$filters)) {
                $newfilters[] = ['name' => $name, ...Filter::$filters[$name]];
            }
        }
        return $newfilters;
    }

    public static function getLaporanFormOptions(string $bigtype, string $type) :array
    {
        return [
            [
                ['type' => 'search', 'name' => 'search', 'placeholder' => 'Cari peserta...'],
            ],
            [
                ['type' => 'select', 'name' => 'type', 'value' => $type, 'options' => static::getTypeOptions($bigtype)],
                ['type' => 'select', 'name' => 'jurusan', 'options' => \App\Models\Jurusan::getOptions()],
                ['type' => 'select', 'name' => 'jalur', 'options' => \App\Models\DataJalurPendaftaran::getAdvancedOptions()],
            ],
            [
                ['type' => 'text', 'name' => 'periode', 'placeholder' => '-- Pilih Periode --', 'attr' => 'daterangepicker'],

                ['type' => 'select', 'name' => 'perPage', 'options' => [
                    ['label' => '-- Per Page --', 'value' => ''],
                    5,10,15,20,25,50,100
                ]],
            ]
        ];
    }

    public static function getVerifikasiFormOptions(string $bigtype) :array
    {
        return [
            [
                ['type' => 'search', 'name' => 'search', 'placeholder' => 'Cari peserta...'],
            ],
            [
                ['type' => 'text', 'name' => 'periode', 'placeholder' => '-- Pilih Periode --', 'attr' => 'daterangepicker'],
                ['type' => 'select', 'name' => 'jurusan', 'options' => \App\Models\Jurusan::getOptions()],
                ['type' => 'select', 'name' => 'jalur', 'options' => \App\Models\DataJalurPendaftaran::getAdvancedOptions()],
                ['type' => 'select', 'name' => 'perPage', 'options' => [
                    ['label' => '-- Per Page --', 'value' => ''],
                    5,10,15,20,25,50,100
                ]],
            ]
        ];
    }

	protected static function initFilters () :array
    {
        return Filter::$filters = array_replace([
            'periode' => ['wheres' => ['periode' => []]],
            'jurusan' => [
                'wheres' => [
                    'whereRelation' => ['jurusan', 'singkatan'],
                ]
            ],
            'jalur' => [
                'wheres' => [
                    'where' => ['jalur_pendaftaran_id'],
                ]
            ],
            'jenis_kelamin' => [
                'wheres' => [
                    'where' => ['jenis_kelamin_id'],
                ]
            ],
            'search' => [
                'variant' => 'midlike',
                'wheres' => [
                    'where' => ['nama_lengkap', 'LIKE'],
                    'orWhere' => ['asal_sekolah', 'LIKE'],
                    'orWhereRelation' => ['pendaftaran', 'kode', 'LIKE'],
                    'orWhereRelation' => ['jurusan', 'kode', 'LIKE'],
                ]
            ],
            'perPage' => ['wheres' => ['perPage' => []]],
            'page' => ['wheres' => ['page' => []]],
        ], Filter::$filters);
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
