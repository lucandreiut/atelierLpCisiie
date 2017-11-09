<?php
/*
	Routes
	controller needs to be registered in dependency.php
*/
//$app->get('/', 'UserController:index')->setName('index');

//Items list page
$app->get('/lists/{id}/items', 'ItemController:getItemsByList')->setName('get_items_by_list');
//Item details page
$app->get('/items/{id}', 'ItemController:getItem')->setName('item_details');
//Add item form page
$app->get('/lists/{id}/items/add', 'ItemController:addItem')->setName('add_item_page');
//Add item action
$app->post('/lists/{id}/items/add', 'ItemController:addItem')->setName('add_item_action');
//Delete item action
$app->post('/items/{id}', 'ItemController:deleteItem')->setName('delete_item');
//List pages
$app->map(['GET', 'POST'], '/lists', 'ListController:lists')->setName('lists');
$app->map(['GET', 'POST'], '/lists/add', 'ListController:add')->setName('addList');
