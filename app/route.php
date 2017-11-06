<?php
/*
	Routes
	controller needs to be registered in dependency.php
*/
//$app->get('/', 'UserController:index')->setName('index');

$app->get('/lists', 'ListController:index')->setName('lists');
