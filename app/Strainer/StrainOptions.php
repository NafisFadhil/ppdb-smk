<?php

namespace App\Strainer;

class StrainOptions {

	/**
	 * Variant of types
	 * 
	 * @var string $suptype
	 * @var string $type
	 * @var string $subtype
	 */
	public string $suptype = '';
	public string $type = '';
	public string $subtype = '';

	/**
	 * Types of filter variants
	 * 
	 * @var array $types
	 */
	public array $types = [];

	/**
	 * Html form filter inputs
	 * 
	 * @var array $options
	 */
	public array $options = [];
	
	/**
	 * Instance constructor
	 */
	public function __construct(array $types) {
		$this->types = $types;
		$this->suptype = $types['suptype'];
		$this->type = $types['type'];
		$this->subtype = $types['subtype'];

		$this->options = $this->resolve();
	}

	/**
	 * Type checking and return options
	 * 
	 * @return array
	 */
	private function resolve() {

		if (in_array($this->type, ['pendaftaran', 'seragam', 'daftar_ulang']) && $this->suptype === 'laporan') {
			return $this->generalOptions();
		} else return $this->nontypeOptions();

	}

	/**
	 * General options
	 * 
	 * @return array
	 */
	private function generalOptions () {
		return [
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
	}

	/**
	 * Nontype options
	 * 
	 * @return array
	 */
	private function nontypeOptions () {
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
	
}
