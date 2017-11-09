<?php
/*
	Routes
	controller needs to be registered in dependency.php
*/
//$app->get('/', 'UserController:index')->setName('index');

$app->get('/lists/{id}/items', 'ItemController:getItemsByList')->setName('get_items_by_list');
$app->get('/lists/{id}/items/add', 'ItemController:addItem')->setName('add_item_page');
$app->post('/lists/{id}/items/add', 'ItemController:addItem')->setName('add_item_action');
$app->map(['GET', 'POST'], '/lists', 'ListController:lists')->setName('lists');
$app->map(['GET', 'POST'], '/lists/add', 'ListController:add')->setName('addList');
$app->map(['GET', 'POST'], '/inscription', 'AuthController:inscription')->setName('inscription');
$app->map(['GET', 'POST'], '/login', 'AuthController:login')->setName('login');
$app->get('/logout', 'AuthController:logout')->setName('logout');