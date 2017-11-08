<?php

namespace App\Middlewares;
/**
* The base middleware
*/
class Middleware
{
	
	protected $container;

	function __construct($container)
	{
		$this->container = $container;
	}
}