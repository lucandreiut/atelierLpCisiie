<?php

namespace App\Controllers;

use App\Models\Message;
use App\Models\Lists;

/**
* 
*/
class MessageController extends BaseController
{
	public function send($request, $response, $args){
		$list = Lists::find($request->getAttribute('route')->getArgument('id'));

		$message = new Message;
		$message->name = $request->getParam('userName');
		$message->message = $request->getParam('userMsg');
		$message->lists_id = $list->id;
		$message->save();

	}

	public function findAll($request, $response, $args){

		$list = Lists::where('sharing_url','like',$request->getAttribute('route')->getArgument('id'))->first();
		$messages = Message::where('lists_id','=',$list->id)->get();

		foreach ($messages as $value) {
			$array[]=$value;
		}

		return $this->container->view->render($response, 'message.twig', array('array' => $array, 'url' => $list->sharing_url));

	}

	public function sendMessage($request, $response, $args){

		$list = Lists::where('sharing_url','like',$request->getAttribute('route')->getArgument('id'))->first();
		//$messages = Message::where('list_id','=',$list->id)->get();

		//foreach ($messages as $value) {
		//	$array[]=$value;
		//}

		$send = new Message;
		$send->name = $request->getParam('name');
		$send->message = $request->getParam('message');
		$send->lists_id = $list->id;
		$send->save();

		$messages = Message::where('lists_id','=',$list->id)->get();
		foreach ($messages as $value) {
			$array[]=$value;
		}

		return $this->container->view->render($response, 'message.twig', array('array' => $array, 'url' => $list->sharing_url));

	}

}