<?php

namespace App\Strainer;

class StrainQueries {
	
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
	 * Queries of filter will executed
	 * 
	 * @var array $queries
	 */
	public array $queries = [];
	
	/**
	 * Get wheres collection filter pre-query
	 */
	public function __construct(array $types) {
		$this->types = $types;
		$this->suptype = $types['suptype'];
		$this->type = $types['type'];
		$this->subtype = $types['subtype'];

		$this->queries = $this->resolve();
	}

	/**
	 * Checking type and return wheres collection
	 */
	private function resolve () {
		$type = $this->type;
		$queries = $this->default();

		// Array replacing
		// if ()
		
		return $queries;
	}

	/**
	 * General wheres filter pre-query
	 */
	private function default () {
		return [
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
        ];
	}
	
}
