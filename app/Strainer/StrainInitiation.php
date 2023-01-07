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
	 * Rules of available all types variant
	 * 
	 * @var array $rules
	 */
	public array $rules = [];

	/**
	 * Initiation options
	 * 
	 * @var array $options
	 */
	public array $options = [];

	/**
	 * With second query to get totals
	 * 
	 * @var boolean $with_total
	 */
	protected bool $with_total = false;
	
	/**
	 * Init required vars before filtering
	 */
	public function __construct(array $types, array $rules = [], array $options = []) {
		$this->types = $types;
		$this->rules = $rules;
		$this->suptype = $types['suptype'];
		$this->type = $types['type'];
		$this->subtype = $types['subtype'];

		$this->form_options = $this->initOptions();
		$this->queries = $this->initQueries();
		$this->names = $this->initNames();

		return [
			'form_options' => $this->form_options,
			'queries' => $this->queries,
			'names' => $this->names,
		];
	}

	/**
	 * Parse options params
	 * 
	 * @return void
	 */
	protected function parseOptions () {
		$options = $this->options;
		$this->with_total = $options['with_total'] ?? $this->with_total;
	}

	/**
	 * Init html form filters
	 * 
	 * @return array
	 */
	private function initOptions () {
		$options = new StrainOptions($this->types, $this->rules);
		return $options->options;
	}

	/**
	 * Init filter queries
	 * 
	 * @return array
	 */
	private function initQueries () {
		$queries = new StrainQueries($this->types, $this->rules);
		return $queries->queries;
	}

	/**
	 * Init names of filters
	 * 
	 * @return array
	 */
	private function initNames () {
		$names = new StrainNames($this->types, $this->rules);
		return $names->names;
	}
	
}
