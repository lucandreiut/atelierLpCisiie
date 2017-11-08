<?php

	namespace App\Controllers;

	/**
	* The base controller
	*/
	class BaseController
	{
		protected $container;

		function __construct($container)
		{
			$this->container = $container;
		}

		public function get($key){
			return $this->container[$key];
		}
	}