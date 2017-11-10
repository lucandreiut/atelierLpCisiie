<?php

namespace App\Controllers;

use App\Models\Item;
use App\Models\Lists;
use Cartalyst\Sentinel\Native\Facades\Sentinel as Sentinel;

class ReservationController extends BaseController
{
    public function index($request, $response, $args)
    {
        $item = Item::find($request->getAttribute('route')->getArgument('id'));
        $verif = $this->verification($item->id);

        return $this->container->view->render($response, 'reservation.twig', array('item' => $item));
    }

    public function reserve($request, $response, $args)
    {
        $item = Item::find($request->getAttribute('route')->getArgument('id'));
        $list = Lists::find($item->lists_id);
        $verif = $this->verification($item->id);
        if ($verif) {
            if ($item->is_crowdfundable) {
                if ($item->current_contribution < $item->price) {
                    $item->current_contribution += $request->getParam('contribution');
                    if ($item->current_contribution >= $item->price) {
                        $item->current_contribution = $item->price;
                        $item->is_reserved = 1;
                    }
                } else {
                    return $this->get('view')->render($response, 'error.twig', array('error' => 'Le cadeau à déjà été financé'));
                }
            } else {
                $item->is_reserved = 1;
            }
            $item->save();
            $contributor = new ContributorController;
            $user = Sentinel::check();
            if($user){
                $contributor->create($user->name , $request->getParam('userMsg'), $item->id);
            }else{
                $contributor->create($request->getParam('userName'), $request->getParam('userMsg'), $item->id);
            }
        }

        return $response->withRedirect('/lists/'.$list->sharing_url.'/items');
    }

    /*	public function dereserve($request, $response, $args){

		//set cookie dans réserver et vérifier ici pour faire la déreservation
		
        $item = Item::find($request->getAttribute('route')->getArgument('id'));
        $list = Lists::find($item->lists_id);
        $verif = $this->verification($item->id);
        if($verif){
            if($item->current_contribution < $item->price){
                $item->curent_contribution += $request->getParam('contribution');
                if($item->current_contribution >= $item->price){
					$item->current_contribution = $item->price;
					$item->is_reserved = 0;
				}
				$item->save();
				$contributor = new ContributorController;
				$contributor->create($request->getParam('userName'), $request->getParam('userMsg'), $item->id);
			 } else {
				die('error');
		 	}
    }

    return $response->withRedirect('/lists/'.$list->sharing_url.'/items');
    }*/

    public function verification($id)
    {
        $boolean = false;
        $item = Item::find($id);
        $list = Lists::find($item->lists_id);
        $datenow = time();
        $target = strtotime($list->limit_date);


        if (!empty($item)) {
            if (!$item->is_reserved) {
                if ($target>$datenow) {
                    $boolean = true;
                } else {
                    return $this->get('view')->render($response, 'error.twig', array('error' => "Il n'est plus possible de réserver sur cette liste"));
                }
            } else {
                return $this->get('view')->render($response, 'error.twig', array('error' => 'Le cadeau à déjà été financé'));
            }
        } else {
            return $this->get('view')->render($response, 'error.twig', array('error' => "Le cadeau n'existe pas"));
        }

        return $boolean;
    }


}