<?php

namespace App\Helpers;

use App\Models\Config as ConfigModel;

class ConfigHelper
{

	public static array $configs;

	public static function init()
	{
		if (isset(static::$configs)) {
			return static::$configs;
		} else {
			return static::$configs = static::parse(ConfigModel::all()->toArray());
		}
	}

	public static function parse(array $configs)
	{
		$new_configs = [];
		foreach ($configs as $config) {
			$new_configs[$config['key']] = $config['value'];
		}
		return $new_configs;
	}

	public static function get(string $key)
	{
		static::init();
		return array_key_exists($key, static::$configs) ? static::$configs[$key] : null;
	}

	public static function update(string $key, $value)
	{
		static::init();
		return ConfigModel::where('key', $key)->update(['value' => $value]);
	}
	
}