<?php

namespace App\Strainer\Contracts;

interface TypeInterface
{
	
	/**
	 * 
	 */
	public function strain ();

	/**
	 * 
	 */
	public function options ();

	/**
	 * 
	 */
	public function names ();

	/**
	 * 
	 */
	public function mockup ();
	
}
