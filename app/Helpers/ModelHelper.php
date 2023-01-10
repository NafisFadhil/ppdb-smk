<?php

namespace App\Helpers;

use App\Models\DataJenisKelamin;
use App\Models\DataJurusan;
use App\Models\Jurusan;
use App\Models\Seragam;
use App\Models\Status;
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

	public static function getPaginateUrl(int $page)
	{
		return request()->fullUrlWithQuery([
			...request()->query->all(),
			'page' => $page
		]);
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
		if (isset($jalur->subjalur)) $str .= ' ' . $jalur->subjalur;
		if (isset($jalur->subjalur2)) $str .= ' ' . $jalur->subjalur2;
		return strtoupper($str);
	}

	public static function implodeJalur(array $jalurs)
	{
		// $str = $jalur->jalur;
		// if (isset($jalur->subjalur)) $str .= ' ' . $jalur->subjalur;
		// if (isset($jalur->subjalur2)) $str .= ' ' . $jalur->subjalur2;
		return strtoupper(implode(' ', $jalurs));
	}

	public static function getJurusan(string $value, string|null $key = 'singkatan')
	{
		return Jurusan::getJurusan($value, $key);
	}

	public static function getJenisKelamin($id)
	{
		return DataJenisKelamin::getJenisKelamin(intval($id));
	}

	public static function getStatusBayar($tagihan, $type)
	{
		if (!$tagihan || !$tagihan->pembayarans) return '-';
		$bayar = static::getBayar($tagihan->pembayarans ?? [], $type);
		$selisih = $tagihan['tagihan_'.$type] - $bayar;
		$lunas = $selisih <= 0;
		$kurang = $lunas ? 0 : $selisih;
		
		if ($tagihan['lunas_'.$type] || $lunas) {
			return 'Lunas';
		} else return 'Kurang ' . NumberHelper::toRupiah($kurang);
	}

	public static function getBayar ($pembayarans = [], $type)
    {
		if (empty($pembayarans)) return 0;
        $bayar = 0;
        foreach ($pembayarans as $pembayaran) {
            if ($pembayaran['type'] === $type) $bayar += $pembayaran['bayar'] ?? 0;
        } return $bayar;
    }

	public static function getStatus (mixed $value, string $key = 'id')
	{
		return Status::getStatus($value, $key);
	}

	public static function getState(bool $bool = null) {
		if ($bool === null) {
			$color = $bool ? 'success' : 'warning';
			$label = $bool ? 'Sudah' : 'Belum';
		} else $color = $label = '';
		return "<span class='text-$color'> $label </span>";
	}

	public static function getBayarState(bool $bool) {
		$color = $bool ? 'success' : 'warning';
		$label = $bool ? 'Lunas' : 'Belum';
		return "<span class='text-$color'> $label </span>";
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

	public static function toTanggal($tanggal = null)
	{
		return date('d-m-Y', $tanggal);
	}

	public static function formatTanggal($tanggal = null)
	{
		$date = new DateTime($tanggal);
		return date_format($date, 'd/m/Y');
	}

	public static function formatTanggalToDaterange($tanggal = null)
	{
		$date = new DateTime($tanggal);
		return date_format($date, 'd/m/Y');
	}

	public static function formatFullTanggal($tanggal = null)
	{
		$date = new DateTime($tanggal);
		return date_format($date, 'D F Y');
	}

	public static function getUkuranSeragam($seragam)
	{
		$results = []; $types = ['olahraga', 'wearpack', 'almamater'];
		$iter = 1;

		foreach ($types as $type) {
			$results[] = $iter++ . '. '. ucfirst($type) . ': ' . $seragam['ukuran_'.$type];
		}
		return implode('<br>', $results);
	}
	
	public static function getNominalBayar($pembayarans, $type)
	{
		$bayars = []; $iter = 1;
		foreach ($pembayarans as $pembayaran) {
			if ($pembayaran['type'] === $type) {
				$bayars[] = $iter++ . '. ' . NumberHelper::toRupiah($pembayaran->bayar);
			}
		}
		return implode('<br/>', $bayars);
	}

	public static function getAdminBayar($pembayarans, $type)
	{
		$admin = []; $iter = 1;
		foreach ($pembayarans as $pembayaran) {
			$name = $pembayaran->admin->name ?? $pembayaran->admin->username ?? '';
			if ($pembayaran['type'] === $type) {
				// $str_lunas = $pembayaran->kurang <= 0 ? ' (Lunas)' : '';
				$str_lunas = '';
				$admin[] = $iter++ . ".${name}${str_lunas}";
			}
		}
		return implode('<br/>', $admin);
	}

	public static function getTanggalBayar($pembayarans, $type)
	{
		$admin = []; $iter = 1;
		foreach ($pembayarans as $pembayaran) {
			if ($pembayaran['type'] === $type) {
				// $str_lunas = $pembayaran->kurang <= 0 ? ' (Lunas)' : '';
				$str_lunas = '';
				$admin[] = $iter++.'. '.static::formatTanggal($pembayaran['created_at']).$str_lunas;
			}
		} return implode('<br/>', $admin);
	}

}