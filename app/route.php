<?php
/*
	Routes
	controller needs to be registered in dependency.php
*/
//$app->get('/', 'UserController:index')->setName('index');




//manque url liste

$app->get('/lists/{id}/items', 'ItemController:getItemsByList')->setName('get_items_by_list');
$app->get('/lists/{id}/items/add', 'ItemController:addItem')->setName('add_item_page');
$app->post('/lists/{id}/items/add', 'ItemController:addItem')->setName('add_item_action');

$app->get('/lists/{id}/message', 'MessageController:findAll')->setName('message');

$app->get('/items/{id}/reservation', 'ReservationController:index')->setName('reservation');
$app->post('/items/{id}/reservation', 'ReservationController:reserve')->setName('reserve_validation');

$app->map(['GET', 'POST'], '/lists', 'ListController:lists')->setName('lists');
$app->map(['GET', 'POST'], '/lists/add', 'ListController:add')->setName('addList');