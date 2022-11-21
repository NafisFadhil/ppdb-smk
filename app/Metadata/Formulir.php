<?php

namespace App\Metadata;

class Formulir
{
	
	public static function inputs ()
	{

		$new_jurusan = [['value' => '', 'label' => 'Pilih Jurusan']];
		$jurusan = Jurusan::$jurusan;
		foreach ($jurusan as $jrsn) $new_jurusan[] = [
			'label' => $jrsn['nama'], 'value' => $jrsn['slug']
		];

		return [
			['type' => 'radio', 'name' => 'jalur_pendaftaran', 
				'values' => ['Umum', 'Prestasi', 'Bintang Kelas'], 
			],
			['type' => 'text', 'name' => 'nama_lengkap', 'label' => null, 'placeholder' => null ], 
			['type' => 'radio', 'name' => 'jenis_kelamin', 'label' => null, 'placeholder' => null,
				'values' => [ 'Laki-laki', 'Perempuan']
			],
			// ['type' => 'text', 'name' => 'tempat_lahir', 'label' => null, 'placeholder' => null ], 
			['type' => 'date', 'name' => 'tanggal_lahir', 'label' => null, 'placeholder' => null ], 
			// ['type' => 'subform', 'label' => 'Alamat Rumah', 'inputs' => [
			// 	[
			// 		['type' => 'text', 'name' => 'alamat_desa', 'label' => 'Nama Desa', 'placeholder' => null],
			// 	],
			// 	[
			// 		['type' => 'number', 'name' => 'alamat_rt', 'label' => 'RT', 'placeholder' => null],
			// 		['type' => 'number', 'name' => 'alamat_rw', 'label' => 'RW', 'placeholder' => null],
			// 	],
			// 	[
			// 		['type' => 'text', 'name' => 'alamat_kec', 'label' => 'Kecamatan', 'placeholder' => null],
			// 	],
			// 	[
			// 		['type' => 'text', 'name' => 'alamat_kota_kab', 'label' => 'Kab/Kota', 'placeholder' => null],
			// 	],
			// ]], 
			// ['type' => 'text', 'name' => 'nama_ayah', 'label' => null, 'placeholder' => null ], 
			// ['type' => 'text', 'name' => 'nama_ibu', 'label' => null, 'placeholder' => null ], 
			// ['type' => 'text', 'name' => 'jumlah_saudara_kandung', 'label' => null, 'placeholder' => null ], 
			// ['type' => 'text', 'name' => 'nik', 'label' => null, 'placeholder' => null ], 
			['type' => 'text', 'name' => 'asal_sekolah', 'label' => null, 'placeholder' => null ], 
			// ['type' => 'text', 'name' => 'nisn', 'label' => null, 'placeholder' => null ], 
			// ['type' => 'text', 'name' => 'no_ujian_nasional', 'label' => null, 'placeholder' => null ], 
			// ['type' => 'text', 'name' => 'no_ijazah', 'label' => 'No Ijazah/Tanggal/Tahun Lulus', 'placeholder' => null ], 
			['type' => 'text', 'name' => 'no_wa_ortu', 'label' => 'WA Ortu/Wali', 'placeholder' => '08xxxxxxxxxx' ], 
			['type' => 'text', 'name' => 'no_wa_siswa', 'label' => 'WA Siswa', 'placeholder' => '08xxxxxxxxxx' ], 
			['type' => 'select', 'name' => 'nama_jurusan', 'label' => null, 'placeholder' => null,
				'options' => $new_jurusan 
			], 
		];
		
	}

	public static function validator ()
	{
		return [
			'jalur_pendaftaran' => 'required|string',
			'nama_lengkap' => 'required|string',
			// 'tempat_lahir' => 'required|string',
			'tanggal_lahir' => 'required|string',
			'jenis_kelamin' => 'required|string',
			// 'alamat_desa' => 'required|string',
			// 'alamat_kec' => 'required|string',
			// 'alamat_kota_kab' => 'required|string',
			// 'alamat_rw' => 'required|numeric',
			// 'alamat_rt' => 'required|numeric',
			// 'nama_ayah' => 'required|string',
			// 'nama_ibu' => 'required|string',
			// 'jumlah_saudara_kandung' => 'nullable|numeric',
			// 'nik' => 'nullable|numeric|digits:16',
			'asal_sekolah' => 'required|string',
			'no_wa_ortu' => 'required|numeric|digits_between:10,14',
			'no_wa_siswa' => 'required|numeric|digits_between:10,14',
			'nama_jurusan' => 'required|string',
		];
	}

}
