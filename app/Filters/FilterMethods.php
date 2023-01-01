<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class FilterMethods
{
	// use FilterAttributes;

	/**
	 * Custom filter perPage
	 * 
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public static function filterPerPage () {
		Filter::$perPage = Filter::$filter['value'];
		return Filter::$model;
	}

	/**
	 * Custom filter page
	 * 
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public static function filterPage () {
		Filter::$page = Filter::$filter['value'];
		return Filter::$model;
	}

	public static function filterPeriode () {
		$periode = Filter::$periode;
		if (Filter::$relation !== '-') {
			return Filter::$model
			->whereRelation(Filter::$relation, DB::raw('DATE(updated_at)'), '>', DB::raw('DATE("'.$periode[0].'")'))
			->whereRelation(Filter::$relation, DB::raw('DATE(updated_at)'), '<', DB::raw('DATE("'.$periode[1].'")'));
		} else {
			return Filter::$model
			->where(DB::raw('DATE(created_at)'), '>', DB::raw('DATE("'.$periode[0].'")'))
			->where(DB::raw('DATE(created_at)'), '<', DB::raw('DATE("'.$periode[1].'")'));
		}
	}

}
