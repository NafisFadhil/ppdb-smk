<?php

namespace App\Filters;

trait GeneralFilter
{
	use FilterAttributes;

	public function xpaginate()
	{
		static::$query->paginate(static::$perPage, ['*'], static::$pageName, static::$page);
		return $this;
	}
	
}
