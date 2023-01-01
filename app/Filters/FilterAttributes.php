<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait FilterAttributes
{
	
	public static array $filters = [];

	public static array $filter = [];
	
	public static array $names = [];

	public static array $wheres = [];

	public static Request $request;

	public static Model|Builder $model;

	public static int $perPage = 15;

	public static string $pageName = 'page';
	
	public static int $page = 1;

	public static string $relation = '';

	public static string $suptype = '';

	public static string $bigtype = '';

	public static string $type = '';

	public static array $periode = [];
	
}
