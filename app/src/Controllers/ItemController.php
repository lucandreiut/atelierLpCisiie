<?php

namespace App\Controllers;

/**
* 
*/
class ItemController extends BaseController
{
	public function index($request, $response, $args){
		return $this->container->view->render($response, 'items.twig');
	}
}