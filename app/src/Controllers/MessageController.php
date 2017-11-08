<?php

namespace App\Controllers;

use App\Models\Message;
use App\Models\Lists;

/**
* 
*/
class ReservationController extends BaseController
{
	public function send($request, $response, $args){
		$list = Lists::find($request->getAttribute('route')->getArgument('id'));

		$message = new Message;
		$message->name = $request->getParam('userName');
		$message->message = $request->getParam('userMsg');
		$message->list_id = $list->id;
		$message->save();

	}

	public function findAll($request, $response, $args){
		$list = Lists::find($request->getAttribute('route')->getArgument('id'));

	

	}

}