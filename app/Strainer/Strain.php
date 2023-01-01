<?php

namespace App\Strainer;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Strain
{
	use StrainAttribute, StrainResolver;

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
	}

	/**
	 * Filter request
	 * 
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function strain(string $type)
	{
		// Resolve strain instance
		$this->typeResolver($type);

		// 
		$this->strain->strain();
		return $this;
	}
	
}
