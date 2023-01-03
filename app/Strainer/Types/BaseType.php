<?php

namespace App\Strainer\Types;

use App\Strainer\Contracts\TypeInterface;

abstract class BaseType implements TypeInterface
{
	
	/**
	 * Type of laporan
	 * 
	 * @var string $type
	 */
	public string $type = '';

	/**
	 * Html form options of filters
	 * 
	 * @var array $options
	 */
	public array $options = [];

	/**
	 * Names list of filter to execute
	 * 
	 * @var array $names
	 */
	public array $names = [];

	/**
	 * Generate new laporan strainer instance
	 */
	public function __construct(string $type) {
		$this->type = $type;
		$this->options = $this->options();
	}

}
