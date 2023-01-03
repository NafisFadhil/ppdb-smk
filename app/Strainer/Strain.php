<?php

namespace App\Strainer;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Strain
{

	/**
	 * The model instance
	 * 
	 * @var \Illuminate\Database\Eloquent\Builder $model
	 */
	public Builder $model;

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
	 * Available type of filter
	 * 
	 * @var array $types
	 */
	protected array $types = ['laporan', 'verifikasi', 'nontype'];
	
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
	 * Create new strain instance
	 * 
	 * @param \Illuminate\Database\Eloquent\Builder $model
	 * @param \Illuminate\Http\Request $request
	 * @param array $options
	 */
	public function __construct(Builder $model, Request $request, array $options) {
		$this->model = $model;
		$this->request = $request;
		$this->options = $options;

		$this->parseOptions();

		$this->grouped_types = StrainHelper::groupTypes(
			$this->suptype, $this->type, $this->subtype
		);

		$this->filter();
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
	 * Filter request main method
	 * 
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function filter() {

		// Init and split common vars
		$init = new StrainInitiation($this->grouped_types);
		$this->form_options = $init->options;
		$this->queries = $init->queries;
		$this->names = $init->names;
		
	}

}
