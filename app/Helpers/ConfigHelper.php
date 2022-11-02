<?php

namespace App\Helpers;

use App\Models\Config as ConfigModel;

class ConfigHelper
{

	public static array $configs;

	public static function init()
	{
		if (isset(self::$configs)) {
			return self::$configs;
		} else {
			return self::$configs = self::parse(ConfigModel::all()->toArray());
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
		self::init();
		return array_key_exists($key, self::$configs) ? self::$configs[$key] : null;
	}

	public static function update(string $key, $value)
	{
		self::init();
		return ConfigModel::where('key', $key)->update(['value' => $value]);
	}
	
}