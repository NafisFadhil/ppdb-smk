<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

trait FilterMethods
{
	use FilterAttributes;

	/**
	 * Custom filter perPage
	 * 
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	protected static function filterPerPage () :Builder
	{
		static::$perPage = static::$filter['value'];
		return static::$model;
	}

	/**
	 * Custom filter page
	 * 
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	protected static function filterPage () {
		static::$page = static::$filter['value'];
		return static::$model;
	}

}
