<?php

namespace App;

class Metaform
{	

	public static function pendaftaran ()
	{

		$new_jurusan = [''];
		$jurusan = \App\Models\Jurusan::select('nama')->get()->toArray();
		foreach ($jurusan as $jrsn) $new_jurusan[] = $jrsn['nama'];

		return [
			['type' => 'hidden', 'name' => 'no_pendaftaran', 'label' => null, 'placeholder' => null ], 
			['type' => 'radio', 'name' => 'jalur_pendaftaran', 
				'values' => ['Umum', 'Prestasi', 'Bintang Kelas', ], 
			],
			['type' => 'text', 'name' => 'nama_lengkap', 'attr' => 'autofocus', 'label' => null, 'placeholder' => null ], 
			['type' => 'text', 'name' => 'tempat_lahir', 'label' => null, 'placeholder' => null ], 
			['type' => 'date', 'name' => 'tanggal_lahir', 'label' => null, 'placeholder' => null ], 
			['type' => 'radio', 'name' => 'jenis_kelamin', 'label' => null, 'placeholder' => null,
				'values' => [ 'Laki-laki', 'Perempuan' ]
			],
			['type' => 'text', 'name' => 'alamat_rumah', 'label' => null, 'placeholder' => null ], 
			['type' => 'text', 'name' => 'nama_ayah', 'label' => null, 'placeholder' => null ], 
			['type' => 'text', 'name' => 'nama_ibu', 'label' => null, 'placeholder' => null ], 
			['type' => 'text', 'name' => 'jumlah_saudara_kandung', 'label' => null, 'placeholder' => null ], 
			['type' => 'text', 'name' => 'nik', 'label' => null, 'placeholder' => null ], 
			['type' => 'text', 'name' => 'asal_sekolah', 'label' => null, 'placeholder' => null ], 
			['type' => 'text', 'name' => 'nisn', 'label' => null, 'placeholder' => null ], 
			['type' => 'text', 'name' => 'no_ujian_nasional', 'label' => null, 'placeholder' => null ], 
			['type' => 'text', 'name' => 'no_ijazah', 'label' => 'No Ijazah/Tanggal/Tahun Lulus', 'placeholder' => null ], 
			['type' => 'text', 'name' => 'no_wa', 'label' => null, 'placeholder' => null ], 
			['type' => 'select', 'name' => 'jurusan', 'label' => null, 'placeholder' => null,
				'values' => $new_jurusan 
			], 
		];
		
	}
}
