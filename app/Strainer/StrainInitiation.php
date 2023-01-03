<?php

namespace App\Strainer;

class StrainInitiation {

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
	 * Html filters inputs form
	 * 
	 * @var array $options
	 */
	public array $options = [];

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
	 * Init required vars before filtering
	 */
	public function __construct(array $types) {
		$this->types = $types;
		$this->suptype = $types['suptype'];
		$this->type = $types['type'];
		$this->subtype = $types['subtype'];

		$this->options = $this->initOptions();
		$this->queries = $this->initQueries();
		$this->names = $this->initNames();

		return [
			'options' => $this->options,
			'queries' => $this->queries,
			'names' => $this->names,
		];
	}

	/**
	 * Init html form filters
	 * 
	 * @return array
	 */
	private function initOptions () {
		$options = new StrainOptions($this->types);
		return $options->options;
	}

	/**
	 * Init filter queries
	 * 
	 * @return array
	 */
	private function initQueries () {
		$queries = new StrainQueries($this->types);
		return $queries->queries;
	}

	/**
	 * Init names of filters
	 * 
	 * @return array
	 */
	private function initNames () {
		$names = new StrainNames($this->types);
		return $names->names;
	}
	
}
