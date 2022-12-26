<?php

namespace App\Validations;

class IdentitasValidation extends Validation
{

	public static function validations ()
	{
		return [
			'nama_lengkap' => 'required|string',
			'tanggal_lahir' => 'required|date',
			'asal_sekolah' => 'required|string',
			'no_wa_siswa' => 'required|numeric',
			'no_wa_ortu' => 'nullable|numeric',
			'tempat_lahir' => 'nullable|string',
			'alamat_desa' => 'nullable|string',
			'alamat_kec' => 'nullable|string',
			'alamat_kota_kab' => 'nullable|string',
			'alamat_rt' => 'nullable|numeric',
			'alamat_rw' => 'nullable|numeric',
			'alamat_gg' => 'nullable|numeric',
			'nama_ayah' => 'nullable|string',
			'nama_ibu' => 'nullable|string',
			'tahun_lahir_ayah' => 'nullable|string',
			'tahun_lahir_ibu' => 'nullable|string',
			'jumlah_saudara_kandung' => 'nullable|numeric',
			'nik' => 'nullable|numeric',
			'nisn' => 'nullable|numeric',
			'no_ujian_nasional' => 'nullable|numeric',
			'no_ijazah' => 'nullable|numeric',
			'buta_warna' => 'nullable',
			'nama_jurusan' => 'required|string',

			'jenis_kelamin_id' => 'required|numeric',
			'jalur_pendaftaran_id' => 'required|numeric',
			'sub_jalur_pendaftaran_id' => 'nullable|required_if:jalur_pendaftaran_id,3|numeric',
			'status_id' => 'required|numeric',
		];
	}
	
}
