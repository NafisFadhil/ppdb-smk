<?php

namespace App\Strainer;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;

trait StrainAttribute
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
	 * Items each page
	 * 
	 * @var int $perPage
	 */
	public int $perPage = 15;

	/**
	 * Number of page
	 * 
	 * @var int $page
	 */
	public int $page = 1;

	/**
	 * Type of filter
	 * 
	 * @var string $type
	 */
	public string $type = '';

	/**
	 * Instance of filter type
	 * 
	 * @var mixed $strain
	 */
	public mixed $strain = null;


}
