<?php

namespace App\Helpers;

use DateTime;

// use App\Models\Pembayaran;
// use Illuminate\Support\Facades\Hash;

class ModelHelper
{

	public static function parseNonAssoc(array $arrays, string $key)
	{
		$new_arrays = [];
		foreach ($arrays as $array) {
			$new_arrays[] = $array[$value ?? 'value'];
		}
		return $new_arrays;
	}

	public static function parseByKey(array $arrays, string $key, string $value)
	{
		$new_arrays = [];
		foreach ($arrays as $array) {
			$new_arrays[$array[$key ?? 'key']] = $array[$value ?? 'value'];
		}
		return $new_arrays;
	}

	public static function getJalur($jalur)
	{
		$str = $jalur->jalur;
		if (isset($jalur->subjalur1)) $str .= ' ' . $jalur->subjalur1;
		if (isset($jalur->subjalur2)) $str .= ' ' . $jalur->subjalur2;
		return strtoupper($str);
	}

	public static function getStatusBayar($tagihan, $type)
	{
		$bayar = static::getBayar($tagihan->pembayarans, $type);
		$selisih = $tagihan['tagihan_'.$type] - $bayar;
		$lunas = $selisih <= 0;
		$kurang = $lunas ? 0 : $selisih;
		
		if ($tagihan['lunas_'.$type] || $lunas) {
			return 'Lunas';
		} else return 'Kurang ' . NumberHelper::toRupiah($kurang);
	}

	public static function getBayar ($pembayarans, $type)
    {
        $bayar = 0;
        foreach ($pembayarans as $pembayaran) {
            if ($pembayaran['type'] === $type) $bayar += $pembayaran['bayar'];
        } return $bayar;
    }

	public static function getTanggalTerakhirBayar($pembayarans, $type)
	{
		$tanggal = '';$last = null;
		foreach ($pembayarans as $pembayaran) {
			if ($pembayaran['type'] === $type) $last = $pembayaran;
		}
		$tanggal = $last['created_at'] ?? null;
		if (!empty($tanggal)) {
			return static::formatTanggal($tanggal);
		} return null;
	}

	public static function formatTanggal($tanggal)
	{
		$date = new DateTime($tanggal);
		return date_format($date, 'd-m-Y');
	}

	public static function getAdminBayar($pembayarans, $type)
	{
		$admin = []; $iter = 1;
		foreach ($pembayarans as $pembayaran) {
			if ($pembayaran['type'] === $type) $admin[] = $iter++ . '. ' . $pembayaran['admin'];
		} return implode('<br/>', $admin);
	}

	public static function getValidations(array $names, array $validations)
	{
		$result = [];
		foreach ($names as $key) {
			$result[$key] = $validations[$key] ?? '';
		}
		return $result;
	}
	
}