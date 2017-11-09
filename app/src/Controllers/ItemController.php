<?php

	namespace App\Controllers;

	use Respect\Validation\Validator as v;
	use App\Models\Lists;
	use App\Models\Item;
	use App\Models\Image;
/**
* The item controller
*/
class ItemController extends BaseController
{
	public function getItemsByList($request, $response, $args){
		$list = Lists::where('sharing_url','LIKE' , $request->getAttribute('route')->getArgument('id'))->first();
		if(empty($list)){
			die('empty');
		}
		$items = $list->items;
		return $this->container->view->render($response, 'items.twig', array('items' => $items, 'url' => $list->sharing_url));
	}

	/*
	**Get single item details
	*/
	public function getItem($request, $response, $args){
		$item = Item::find($request->getAttribute('route')->getArgument('id'));
		if(empty($item)){
			die('Item not found');
		}
		return $this->get('view')->render($response, 'item_details.twig', array('item' => $item));
	}

	public function addItem($request, $response, $args){
		//If the http request is a post request
		//We handle the form to add a new item
		if($request->isPost()){
			$postData = $request->getParsedBody();
			$errors = array('general' => array());
			//User input validation
			if(!v::notBlank()->validate($postData['title'])){
				$errors['title'] = "Le titre est obligatoire";
			}
			if(!v::notBlank()->validate($postData['description'])){
				$errors['description'] = "La description est obligatoire";
			}
			if(!v::floatVal()->validate($postData['price'])){
				$errors['price'] = "Le prix doit être une valeur numérique valide";
			}
			if(!empty($postData['url']) && !v::url()->validate($postData['url'])){
				$errors['url'] = "Le format de l'url n'est pas valide";
			}
			if(isset($postData['lists_id']) && $postData['lists_id']){
				$list = Lists::find($postData['lists_id']);
				if(empty($list)){
					$errors['general'][] = "La liste associée est introuvable";
				}else{
					$limit_date = new \Datetime($list->limit_date);
					if($limit_date < new \Datetime()){
						$errors['general'][] = "La liste associée est expirée";
					}else{
						if(count($errors) <= 1 && count($errors['general']) == 0){
							//Creating the item object and saving it
							$item = new Item();
							$item->title = $postData['title'];
							$item->description = $postData['description'];
							$item->price = $postData['price'];
							$item->url = $postData['url'];
							if(isset($postData['is_crowdfundable'])){
								$item->is_crowdfundable = TRUE;
							}else{
								$item->is_crowdfundable = FALSE;
							}
							$list->items()->save($item);
							//Add images to the item

							$images = [];
							$allowedExtensions = ['png', 'PNG', 'jpg', 'JPG', 'jpeg', 'JPEG'];
							$uploadedFiles = $request->getUploadedFiles();
							if(count($uploadedFiles['images']) !== 0){
								foreach ($uploadedFiles['images'] as $key => $uploadedFile) {
									if($uploadedFile->getError() === UPLOAD_ERR_OK ){

										$extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
										if(!in_array($extension, $allowedExtensions)){
											continue;
										}
									    $basename = md5($item->id.$key);
									    $filename = sprintf('%s.%0.8s', $basename, $extension);
									    $uploadedFile->moveTo($this->get('upload_path').DIRECTORY_SEPARATOR . $filename);
										$images[] = ['url' => $filename];
									}
								}
								$item->images()->createMany($images);
							}
							return $this->container->view->render($response, 'items.twig', array('items' => $list->items));
						}
					}
				}
			}elseif(isset($postData['group_id']) && $postData['group_id']){
				//Groups logic
			}else{
				$errors['general'][] = "Aucune liste ou groupe n'est défini";
			}
			if(count($errors) > 1 || count($errors['general']) > 0){
				$_SESSION['errors'] = $errors;
				return $response->withRedirect($this->get('router')->pathFor('add_item_page', array('id' => $list->sharing_url)));
			}
		}
		//If it's a get request we show the add item form
		else{
			$list = Lists::where('sharing_url','LIKE' , $request->getAttribute('route')->getArgument('id'))->first();
			if(empty($list)){
				die('empty');
			}
			return $this->container->view->render($response, 'add_item.twig', array('list' => $list, 'group' => null));
		}

	}

	/*
	** Delete item
	*/

	public function deleteItem($request, $response, $args){
		$item = Item::find($request->getAttribute('route')->getArgument('id'));
		if(empty($item)){
			die('Cadeau introuvable');
		}
		if($item->limit_date > new \Datetime()){
			die('Cadeau introuvable');
		}
		/*
		* Here goes the authentication logic
		*/
		$sharing_url = $item->lists->sharing_url;
		$item->delete();

		return $response->withRedirect($this->get('router')->pathFor('get_items_by_list', array('id' => $sharing_url)));
	}

}

