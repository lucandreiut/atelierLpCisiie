<?php
/*
	Routes
	controller needs to be registered in dependency.php
*/
//$app->get('/', 'UserController:index')->setName('index');

$app->get('/lists', 'ListController:index')->setName('lists');

$app->get('/lists/{id}/items', 'ItemController:getItemsByList')->setName('get_items_by_list');

$app->get('/lists/{id}/items/add', 'ItemController:addItem')->setName('add_item_page');

$app->post('/lists/{id}/items/add', 'ItemController:addItem')->setName('add_item_action');