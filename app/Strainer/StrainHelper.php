<?php

namespace App\Strainer;

trait StrainHelper
{
	
	/**
	 * Get class name of filter type
	 * 
	 * @return string
	 */
	protected function getTypeInstanceName() {
		return ucfirst($this->type);
	}

	// protected function asd() {}
	
}
