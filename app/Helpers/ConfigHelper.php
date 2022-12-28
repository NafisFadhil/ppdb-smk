<?php

namespace App\Helpers;

use App\Models\Config as ConfigModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ConfigHelper
{

	public static function getConfigs ()
	{
		return Cache::rememberForever('configs', fn() => ConfigModel::all());
	}

	public static function parse(mixed $configs)
	{
		$new_configs = [];
		foreach ($configs as $config) {
			$new_configs[$config['key']] = $config['value'];
		}
		return $new_configs;
	}

	public static function get(string $key)
	{
		$configs = static::getConfigs();
		return $configs->get($key) ?? null;
	}

	public static function update(string $key, $value)
	{
		$configs = static::getConfigs();
		return ConfigModel::where('key', $key)->update(['value' => $value]);
	}

	// public static function getKontak(string $name, string|null $key)
	// {
	// 	$configs = static::getConfigs();
	// 	$config = json_decode($configs['kontak_'.$name]??json_encode([]), true);
	// 	return $config[$key] ?? null;
	// }
	
}