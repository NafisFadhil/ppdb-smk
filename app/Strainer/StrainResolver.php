<?php

namespace App\Strainer;

trait StrainResolver
{
	
	use StrainAttribute, StrainHelper;

	/**
	 * Available value type of filter
	 * 
	 * @var array $types
	 */
	protected array $types = ['laporan', 'verifikasi', 'nontype'];
	
	/**
	 * Resolve type of filter and throw to the instance
	 * 
	 * @param string $type
	 */
	public function typeResolver(string $type) {
		if (in_array($type, $this->types)) {
			$this->type = $type;
		}

		return $this;
	}

	/**
	 * Resolve type of filter and throw to the instance
	 */
	public function typeInstanceResolver() {
		$type_class_name = implode("\\", ['Types', $this->getTypeInstanceName()]);

		if (class_exists($type_class_name)) {
			$this->strain = new $type_class_name();
		}

		return $this;
	}

}
