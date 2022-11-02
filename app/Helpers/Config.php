<?php

namespace App\Helpers;

use App\Models\Config as ConfigModel;

class Config {

	public $configs;

	public function __construct()
	{
		$this->configs = $this->parse(ConfigModel::all()->toArray());
	}

	public function parse(array $configs)
	{
		$new_configs = [];
		foreach ($configs as $config) {
			$new_configs[$config['key']] = $config['value'];
		}
		return $new_configs;
	}

	public function get(string $key)
	{
		return array_key_exists($key, $this->configs) ? $this->configs[$key] : null;
	}

	public function set(string $key, $value)
	{
		return ConfigModel::where('key', $key)->update(['value' => $value]);
	}
	
}