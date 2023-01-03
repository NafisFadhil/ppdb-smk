<?php

namespace App\Strainer\Types;

use App\Strainer\Contracts\TypeInterface;

class Laporan extends BaseType
{

	public function options() {
		$options = [
            [
                [
					'type' => 'search',
					'name' => 'search',
					'placeholder' => 'Cari peserta...'
				],
            ],
            [
                [
					'type' => 'select',
					'name' => 'type',
					'value' => $this->type,
					'options' => [
						['label' => '-- Pilih Laporan --', 'value' => ''],
						[
							'label' => \Illuminate\Support\Str::title(str_replace('_', ' ', $this->type)),
							'value' => $this->type
						],
						[
							'label' => 'Pembayaran',
							'value' => 'pembayaran'
						],
					],
				],

                [
					'type' => 'select',
					'name' => 'jurusan',
					'options' => \App\Models\Jurusan::getOptions()
				],
                [
					'type' => 'select',
					'name' => 'jalur',
					'options' => \App\Models\DataJalurPendaftaran::getAdvancedOptions()
				],
            ],
            [
                [
					'type' => 'text',
					'name' => 'periode',
					'placeholder' => '-- Pilih Periode --',
					'attr' => 'daterangepicker'
				],
                [
					'type' => 'select',
					'name' => 'perPage',
					'options' => [
						['label' => '-- Per Page --', 'value' => ''],
						5,10,15,20,25,50,100
					]
				],
            ]
        ];

		return $options;
	}

	public function names() {
		$names = [
			'search',
			'jurusan',
			'jalur',
			'periode',
			'jenis_kelamin',
			'perPage',
			'page',
		];

		return $names;
	}
	
}
