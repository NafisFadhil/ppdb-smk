<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class Filter
{
	use FilterAttributes, FilterOptions, FilterMethods;

	/**
	 * Create query builder instance query
	 * 
	 * @return \Illuminate\Pagination\LengthAwarePaginator
	 */
	public static function filter (
		Model|Builder $model,
		Request $request,
		array $filters = [],
		array|null $names = null
	) :LengthAwarePaginator
	{
		static::$filters = static::getFilters($filters, $names); // Replace recursive
		static::$request = $request;
		static::$model = $model;
		
		foreach (static::$filters as $filter) {
			$filter = static::initFilter($filter);
			if ($request->has($filter['name'])) {
				if (empty($request->filled($filter['name']))) {
					unset($request[$filter['name']]);
					continue;
				};

				$filter['wheres'] = static::initWheres($filter);
				static::getFilter($filter);
			}
		}
		return static::paginate(static::$model);
	}

	/**
	 * Init default filter value
	 * 
	 * @param array $filter
	 * @return array
	 */
	protected static function initFilter(array $filter) :array
	{
		return [
			'name' => $filter['name'] ?? null,
			'field' => $filter['field'] ?? $filter['name'] ?? null,
			'variant' => $filter['variant'] ?? 'default',
			'wheres' => $filter['wheres'] ?? null,
			'value' => static::$request->get($filter['name']) ?? null,
		];
	}
	
	/**
	 * Filter condition for custom value
	 * 
	 * @param array $filter
	 * @return array
	 */
	protected static function initWheres (array $filter) :array
	{
		$wheres = [];;
		foreach ($filter['wheres'] as $type => $conds) {
			$value = $filter['value']; 
			$variant = $filter['variant'];

			if ($variant === 'midlike') $value = "%$value%";
			$wheres[$type] = static::insertWhereValue($conds, $value);
		}
		return $wheres;
	}

	/**
	 * Insert value from query parameter to conditions array
	 * 
	 * @param array $conds
	 * @param string|null $value
	 * @return array
	 */
	protected static function insertWhereValue (array $conds, string|null $value = null) :array
	{
		if (count($conds) >= 3) {
			array_splice($conds, 2, 0, $value);
		} else $conds[] = $value;

		return $conds;
	}

	/**
	 * Get value from query paramter
	 * 
	 * @param string $name
	 * @return string|int|null
	 */
	public static function getValue (string $name)
	{
		return static::$request->get($name);
	}

	/**
	 * Call filter each wheres
	 * 
	 * @param array $filter
	 * @return void
	 */
	protected static function getFilter (array $filter) :void
	{
		static::$filter = $filter;
		foreach ($filter['wheres'] as $type => $conds) {
			$uctype = ucfirst($type);
			$method = 'filter'.$uctype;
			if (method_exists(static::class, $method)) {
				static::$model = static::$method($conds);
			} else static::$model = static::globalFilter($type, $conds);
		}
	}

	/**
	 * Global filter method for unavailable custom filter method
	 * Call query model each filter
	 * 
	 * @param string $type
	 * @param array $conditions
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	protected static function globalFilter (string $type, array $conditions) :Builder
	{
		$type = Str::camel($type);
		return static::$model->$type(...$conditions);
	}

	/**
	 * Custom paginate overwrite builder paginate method
	 * 
	 * @return \Illuminate\Pagination\LengthAwarePaginator
	 */
	public static function paginate (Builder $query) :LengthAwarePaginator
	{
		return $query->paginate(
            perPage: static::getValue('perPage') ?? static::$perPage,
            page: static::getValue('page') ?? static::$page
        );
	}

}
