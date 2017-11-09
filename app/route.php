<?php
/*
	Routes
	controller needs to be registered in dependency.php
*/


//Items list page
$app->get('/lists/{id}/items', 'ItemController:getItemsByList')->setName('get_items_by_list');
//Item details page

$app->get('/items/{id}', 'ItemController:getItem')->setName('item_details');
//Add item form page
$app->get('/lists/{id}/items/add', 'ItemController:addItem')->setName('add_item_page');

//Add item action
$app->post('/lists/{id}/items/add', 'ItemController:addItem')->setName('add_item_action');


$app->get('/lists/{id}/message', 'MessageController:findAll')->setName('message');

$app->post('/lists/{id}/message', 'MessageController:sendMessage')->setName('send_message');


$app->get('/items/{id}/reservation', 'ReservationController:index')->setName('reservation');
$app->post('/items/{id}/reservation', 'ReservationController:reserve')->setName('reserve_validation');

//Delete item action
$app->post('/items/{id}', 'ItemController:deleteItem')->setName('delete_item');
//List pages

$app->map(['GET', 'POST'], '/lists', 'ListController:lists')->setName('lists');

$app->map(['GET', 'POST'], '/lists/add', 'ListController:add')->setName('addList');
$app->map(['GET', 'POST'], '/inscription', 'AuthController:inscription')->setName('inscription');
$app->map(['GET', 'POST'], '/login', 'AuthController:login')->setName('login');
$app->get('/logout', 'AuthController:logout')->setName('logout');

$app->get('/', 'AuthController:index')->setName('index');

