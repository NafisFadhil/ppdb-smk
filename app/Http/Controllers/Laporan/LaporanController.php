<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{

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

    // protected function getTahunOptions ()
    // {}

}
