<?php

namespace App\Strainer;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Strain
{
	use StrainHelper;

	/**
	 * The query builder instance
	 * 
	 * @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Contracts\Pagination\LengthAwarePaginator $query
	 */
	public EloquentBuilder|LengthAwarePaginator $query;
	
	/**
	 * The query builder instance
	 * 
	 * @var \Illuminate\Database\Query\Builder|null $subquery
	 */
	public Builder|null $subquery;

	/**
	 * The request instance
	 * 
	 * @var \Illuminate\Http\Request $request
	 */
	public Request $request;

	/**
	 * Additional option attributes
	 * 
	 * @var array $options
	 */
	public array $options = [];

	/**
	 * Items each page for pagination
	 * 
	 * @var int $perPage
	 */
	public int $perPage = 15;

	/**
	 * Number of page for pagination
	 * 
	 * @var int $page
	 */
	public int $page = 1;

	/**
	 * Instance of filter type
	 * 
	 * @var mixed $strain
	 */
	public mixed $strain = null;

	/**
	 * Current filter looping
	 * 
	 * @var array $filter
	 */
	public array $filter = [];

	/**
	 * Filtered name, debug var
	 * 
	 * @var array $filter
	 */
	public array $filters = [];

	/**
	 * Current suptype to filter
	 * Ex. laporan, verifikasi, etc.
	 * 
	 * @var string $type
	 */
	public string $suptype = '';

	/**
	 * Current type to filter
	 * Ex. pendaftaran, seragam, etc.
	 * 
	 * @var string $type
	 */
	public string $type = '';

	/**
	 * Current subtype to filter
	 * Ex. [type] or pembayaran.
	 * 
	 * @var string $subtype
	 */
	public string $subtype = '';

	/**
	 * Available super types of filter
	 * 
	 * @var array $suptypes
	 */
	protected array $suptypes = ['laporan', 'verifikasi', 'nontype'];

	/**
	 * Available types of filter
	 * 
	 * @var array $types
	 */
	protected array $types = [
		'pendaftaran', 'daftar_ulang',
		'seragam', 'pendataan', 'sponsorship'
	];

	/**
	 * Available sub types of filter
	 * 
	 * @var array $suubtypes
	 */
	protected array $subtypes = ['pembayaran'];
	
	/**
	 * Grouped variant of types
	 * 
	 * @var array $types
	 */
	protected array $grouped_types = [];

	/**
	 * Array of html form input filters
	 * 
	 * @var array $form_options
	 */
	public array $form_options = [];

	/**
	 * Filter queries array collection
	 * 
	 * @var array $queries
	 */
	public array $queries = [];

	/**
	 * Names of filter will execute
	 * 
	 * @var array $names
	 */
	public array $names = [];

	/**
	 * Paginate the query result
	 * 
	 * @var boolean $with_paginate
	 */
	public bool $with_paginate = true;

	/**
	 * Create subquery for total aggregation
	 * 
	 * @var boolean $with_subquery
	 */
	public bool $with_subquery = true;

	/**
	 * Create new strain instance
	 * 
	 * @param \Illuminate\Database\Query\Builder $query
	 * @param Illuminate\Contracts\Pagination\LengthAwarePaginator $query
	 * @param \Illuminate\Http\Request $request
	 * @param array $options
	 */
	public function __construct(EloquentBuilder $query, Request $request, array $options) {
		// Saving param value to class properties
		$this->query = $query;
		$this->request = $request;
		$this->options = $options;

		// Parse options on third parameter
		$this->parseOptions();

		// Statement after parsing options
		$this->grouped_types = static::groupTypes(
			$this->suptype, $this->type, $this->subtype
		);

		// Initiate subquery builder for sum aggregation
		if ($this->with_subquery) {
			$this->initSubquery();
		}

		// Execute program
		$this->filter();


		// Execute subquery builder
		// if ($this->with_subquery) {
		// 	$this->subquery = json_decode(json_encode($this->subquery->get()->first()), true);
		// }

		// Paginate
		if ($this->with_paginate) {
			$this->query = static::paginate($this->query, $this->perPage, $this->page);
		}
	}

	/**
	 * Parse option parameters or set to default if not present
	 * 
	 * @return void
	 */
	protected function parseOptions () {
		$this->perPage = $this->getOption('perPage', $this->perPage);
		$this->page = $this->getOption('page', $this->page);
		$this->suptype = $this->getOption('suptype', $this->suptype);
		$this->type = $this->getOption('type', $this->type);
		$this->subtype = $this->getOption('subtype', $this->type);
		$this->with_paginate = $this->getOption('with_paginate', $this->with_paginate);
		$this->with_subquery = $this->getOption('with_subquery', $this->with_subquery);
	}

	/**
	 * Helper to get option
	 * 
	 * @param string $key
	 * @param mixed $default
	 * @param array|null $options
	 * @return mixed
	 */
	public function getOption (string $key, mixed $default, array|null $options = null) {
		$options ??= $this->options;
		if (array_key_exists($key, $options)) {
			return $options[$key] ?? null;
		} elseif (in_array($key, $options)) {
			return true;
		} return $default;
	}

	/**
	 * Get request query parameter
	 * 
	 * @param string|null $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function getParam (string|null $name, mixed $default = null) {
		if (is_null($name)) return;
		
		return $this->request->query($name, $default);
	}

	/**
	 * Filter request main method
	 * 
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function filter() {

		// Init and split common vars
		$init = new StrainInitiation($this->grouped_types, [
			'suptype_rules' => $this->suptypes,
			'type_rules' => $this->types,
			'subtype_rules' => $this->subtypes,
		]);
		
		// Saving initiated filter array to class properties
		$this->form_options = $init->form_options;
		$this->queries = $init->queries;
		$this->names = $init->names;

		// Loop over queries
		foreach ($this->queries as $name => $filter) {

			// Conditional checking if empty url query param
			if (!in_array($name, $this->names)) continue;
			elseif (!$this->request->query->has($name)) continue;
			elseif (!$this->request->filled($name)) continue;

			// Filtering
			$filter['name'] = $name;
			$this->filter = $filter;
			$this->initFilter()->initWheres();
		}

		return $this;

	}

	/**
	 * Initiation default query builder instance
	 * 
	 * @return void
	 */
	protected function initSubquery () {
		$type = $this->type;
		$this->subquery = DB::table('identitas')
		    ->join('jurusans as jurusan', 'jurusan.identitas_id', 'identitas.id')
		    ->join('data_jalur_pendaftarans as jalur_pendaftaran', 'identitas.jalur_pendaftaran_id', 'jalur_pendaftaran.id')
		    ->join('data_jenis_kelamins as jenis_kelamin', 'identitas.jenis_kelamin_id', 'jenis_kelamin.id')
		    ->join('tagihans as tagihan', 'tagihan.identitas_id', 'identitas.id')
		    ->join('verifikasis as verifikasi', 'verifikasi.identitas_id', 'identitas.id')
		    ->join('statuses as status', 'identitas.status_id', 'status.id')
			->leftJoin('pembayarans', function ($join) use ($type) {
				$join->on('pembayarans.identitas_id', 'identitas.id')
					->where('pembayarans.type', $type);
			})
			->select([
				DB::raw('SUM(pembayarans.bayar) as total_bayar'),
				DB::raw('SUM(tagihan.biaya_'.$type.') as total_biaya'),
				DB::raw('SUM(tagihan.tagihan_'.$type.') as total_tagihan'),
			]);
	}

	/**
	 * Initiation default filters array
	 */
	protected function initFilter () {
		$this->filter = [
			'name' => $this->filter['name'] ?? null,
			'variant' => $this->filter['variant'] ?? 'default',
			'wheres' => $this->filter['wheres'] ?? [],
			'value' => $this->getParam($this->filter['name'] ?? null),
		];
		
		return $this;
	}

	/**
	 * Initiation wheres query and veriant, then insert request value
	 */
	protected function initWheres () {
		$filter = $this->filter;
		$value = $this->getParam($filter['name']);
		
		foreach ($filter['wheres'] as $where => $conds) {

			// Insert value
			if ($filter['name'] === 'search')  {
				$conds[] = '%' . $value . '%';
			} elseif ($filter['name'] === 'periode') {
				$conds = explode(' - ', $value);
			} else $conds[] = $value;


			// Call own method or query builder method if exists
			$method_name = 'filter' . ucfirst($where);
			if (method_exists($this, $method_name)) {
				$this->$method_name($conds);
			} else {
				// Query
				if (method_exists($this->query, $where)) {
					$this->query->$where(...$conds);
				}
				// Subquery
				if ($this->with_subquery && method_exists($this->subquery, $where)) {
					$this->subquery->$where(...$conds);
				}
			}
		}

		return $this;
	}

	/**
	 * Change perPage number of pagination
	 */
	protected function filterPerPage (array $conds) {
		$this->perPage = $conds[0];
	}

	/**
	 * Change number of page for pagination
	 */
	protected function filterPage (array $conds) {
		$this->page = $conds[0];
	}

	/**
	 * Custom query builder for periode filter
	 */
	protected function filterPeriode (array $periodes) {
		$refer = DB::raw('DATE(identitas.updated_at)');
		$start = DB::raw('DATE("' . $periodes[0] . '")');
		$end = DB::raw('DATE("' . $periodes[1] . '")');
		
		$this->query
			->where($refer, '>=', $start)
			->where($refer, '<=', $end);
			
		if ($this->with_subquery) {
			$this->subquery
				->where($refer, '>=', $start)
				->where($refer, '<=', $end);
		}

		return $this;
	}

	/**
	 * Relation and join for both queries
	 */
	protected function filterWhereRelation (array $conds) {
		$table_name = \Illuminate\Support\Str::plural($conds[0]);
		$value = $conds[count($conds) - 1] ?? null;
		$newvalue = strtolower($conds[2]) === 'like' ? 'LIKE "'.$value.'"' : $value;
		
		$this->query->whereRelation(...$conds);

		if ($this->with_subquery) {
			$this->subquery->whereExists(function ($query) use ($table_name) {
				$query->select(DB::raw(1))->from($table_name)
					->whereColumn($table_name.'.identitas_id', 'identitas.id');
			})->where($conds[0].'.'.$conds[1], $newvalue);
		}
	}

	protected function filterOrWhereRelation (array $conds) {
		$table_name = \Illuminate\Support\Str::plural($conds[0]);
		$value = $conds[count($conds) - 1] ?? null;
		$newvalue = strtolower($conds[2]) === 'like' ? 'LIKE "'.$value.'"' : $value;
		
		$this->query->orWhereRelation(...$conds);

		if ($this->with_subquery) {
			$this->subquery->whereExists(function ($query) use ($table_name) {
				$query->select(DB::raw(1))->from($table_name)
					->whereColumn($table_name.'.identitas_id', 'identitas.id');
			})->orWhere($conds[0].'.'.$conds[1], $newvalue);
		}
	}

}
