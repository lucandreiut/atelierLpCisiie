<?php
/*
	Routes
	controller needs to be registered in dependency.php
*/
//$app->get('/', 'UserController:index')->setName('index');

$app->map(['GET', 'POST'], '/lists', 'ListController:lists')->setName('lists');
$app->map(['GET', 'POST'], '/lists/add', 'ListController:add')->setName('addList');
