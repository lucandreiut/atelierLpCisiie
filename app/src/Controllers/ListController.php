<?php

namespace App\Controllers;

/**
* 
*/
class ListController extends BaseController
{
	public function index($request, $response, $args){
		return $this->container->view->render($response, 'lists.twig');
	}
}