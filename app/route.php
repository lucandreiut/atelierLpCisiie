<?php
/*
	Routes
	controller needs to be registered in dependency.php
*/
//$app->get('/', 'UserController:index')->setName('index');

$app->get('/lists', 'ListController:index')->setName('lists');
$app->get('/items/{id}/reservation', 'ReservationController:index')->setName('reservation');
$app->post('/items/{id}/reservation', 'ReservationController:reserve')->setName('reserve_validation');
//manque url liste
