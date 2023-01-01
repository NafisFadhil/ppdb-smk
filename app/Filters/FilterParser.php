<?php

namespace App\Filters;

class FilterParser
{

	public static function parseNames () {
		if (Filter::$suptype === 'laporan') {
			Filter::$names = [
				'search', 'jurusan', 'jalur', 'periode',
				'jenis_kelamin', 'perPage', 'page',
			];
		}
		elseif (Filter::$suptype === 'verifikasi') {
			Filter::$names = [
				'search', 'jurusan', 'jalur', 'periode',
				'jenis_kelamin', 'perPage', 'page',
			];
		}
		elseif (Filter::$suptype === 'nontype') {
			Filter::$names = [
				'search', 'jurusan', 'jalur', 'periode',
				'jenis_kelamin', 'perPage', 'page',
			];
		}
	}
	
	public static function parseFilters () {
		if (Filter::$suptype === 'laporan') {
			Filter::$filters = array_replace([], Filter::$filters);
		}
		elseif (Filter::$suptype === 'verifikasi') {
			Filter::$filters = array_replace([], Filter::$filters);
		}
		elseif (Filter::$suptype === 'nontype') {
			Filter::$filters = array_replace([], Filter::$filters);
		}
	}

}
