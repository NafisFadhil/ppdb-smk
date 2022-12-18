<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class Filter
{
	use FilterAttributes;

	/**
	 * Create query builder instance query
	 * 
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public static function filter (Model|Builder $model, Request $request, array $filters)
	{
		static::$filters = $filters;
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

		return static::$model;
	}

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
	
	protected static function initWheres (array $filter)
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

	protected static function insertWhereValue (array $conds, string|null $value = null) :array
	{
		if (count($conds) >= 3) {
			array_splice($conds, 2, 0, $value);
		} else $conds[] = $value;

		return $conds;
	}

	public static function getValue (string $name)
	{
		return static::$request->get($name);
	}

	protected static function getParams (array $filter)
	{
		$type = $filter['type'];
		if (in_array($type, ['tanggal', 'bulan', 'tahun'])) {
			return [$filter['table'], $filter['value']];
		} elseif ($type === 'wheres') {
			return [[...$filter['wheres'], $filter['value']]];
		}
	}

	protected static function getFilter (array $filter)
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

	protected static function globalFilter (string $type, array $conditions)
	{
		$type = Str::camel($type);
		return static::$model->$type(...$conditions);
	}

	protected static function filterPerPage () {
		static::$perPage = static::$filter['value'];
		return static::$model;
	}
	protected static function filterPage () {
		static::$page = static::$filter['value'];
		return static::$model;
	}

	// protected static function filterWhere (array $conditions) {
	// 	return static::$model->where(...$conditions);
	// }
	// protected static function filterWhereLike (array $conditions) {
	// 	return static::$model->where(...$conditions);
	// }
	// protected static function filterOrWhereLike (array $conditions) {
	// 	return static::$model->orWhere(...$conditions);
	// }
	// protected static function filterRelation (array $conditions) {
	// 	return static::$model->whereRelation(...$conditions);
	// }
	// protected static function filterOr (array $conditions) {
	// 	return static::$model->orWhere(...$conditions);
	// }

}
