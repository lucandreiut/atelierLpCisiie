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
		$message->list_id = $list->id;
		$message->save();

	}

	public function findAll($request, $response, $args){

		$list = Lists::where('sharing_url','like',$request->getAttribute('route')->getArgument('id'))->first();
		$messages = Message::where('list_id','=',$list->id)->get();

	//	$array = (array) $messages;

		foreach ($messages as $value) {
 		  // echo $value->name.' : ';
 		  // echo '<br/>';
 		  // echo $value->message;
 		  // echo '<br/>';
 		  // echo '<br/>';

			$array[]=$value;

		}

		//echo $array[0]->name;





		return $this->container->view->render($response, 'message.twig', array('array' => $array));

	}

}