<?php

namespace App\Controllers;

use App\Models\Contributor;

/**
* 
*/
class ContributorController extends BaseController
{
	public function contribute($request, $response, $args){
		$contributor = new Contributor;
		$contributor->name = $request->getParam('userName');
		$contributor->message = $request->getParam('userMsg');
		$contributor->item_id = $item->id;
		$contributor->save();
	}

	public function create($name, $msg, $id){
		$contributor = new Contributor;
		$contributor->name = $name;
		$contributor->message = $msg;
		$contributor->item_id = $id;
		$contributor->save();
	}
}