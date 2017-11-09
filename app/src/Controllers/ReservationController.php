<?php

namespace App\Controllers;

use App\Models\Item;
use App\Models\Lists;

/**
* 
*/
class ReservationController extends BaseController
{
	public function index($request, $response, $args){
		$item = Item::find($request->getAttribute('route')->getArgument('id'));
		$verif = $this->verification($item->id);

		return $this->container->view->render($response, 'reservation.twig', array('item' => $item));
	}

	public function reserve($request, $response, $args){
		$item = Item::find($request->getAttribute('route')->getArgument('id'));
		$list = Lists::find($item->lists_id);
		$verif = $this->verification($item->id);
		if($verif){
			$item->is_reserved = 1;
			$item->save();
			$contributor = new ContributorController;
			$contributor->create($request->getParam('userName'), $request->getParam('userMsg'), $item->id);
		}

		return $response->withRedirect('/lists/'.$list->sharing_url.'/items');
	}

	public function verification($id){
		$boolean = false;
		$item = Item::find($id);
		$list = Lists::find($item->lists_id);
		$datenow = time();
		$target = strtotime($list->limit_date);
		

		if (!empty($item)){
			if (!$item->is_reserved){
				if ($target>$datenow){
					$boolean = true;
				} else {
					die('date expirée');
				}
			} else {
				die('cadeau déjà réservé');
			}
		} else {
			die("le cadeau n'existe pas");
		}

		return $boolean;
	}
}