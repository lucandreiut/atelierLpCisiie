<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// Register component on container
$container['view'] = function ($c) {
    $settings = $c->get('settings')['view'];
    $view = new \Slim\Views\Twig($settings['template_path'], [
        'debug' => $settings['debug'],
        'cache' => $settings['cache_path']
    ]);
	// Add extensions
    $view->addExtension(new \Slim\Views\TwigExtension(
        $c['router'],
        $c['request']->getUri()
    ));
    $view->addExtension(new Twig_Extension_Debug());
    // $view->getEnvironment()->addGlobal('baseUrl', '/issam/ShoesRental');
    $view->getEnvironment()->addGlobal('session', $_SESSION);    
    $view->getEnvironment()->addGlobal('flash', $c['flash']);
    return $view;
};

// Flash messages
$container['flash'] = function ($c) {
    return new Slim\Flash\Messages;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};

// error handle
$container['errorHandler'] = function ($c) {
  return function ($request, $response, $exception) use ($c) {
    $data = [
      'code' => $exception->getCode(),
      'message' => $exception->getMessage(),
      'file' => $exception->getFile(),
      'line' => $exception->getLine(),
      'trace' => explode("\n", $exception->getTraceAsString()),
    ];

    return $c->get('response')->withStatus(500)
             ->withHeader('Content-Type', 'application/json')
             ->write(json_encode($data));
  };
};

// Generate Activation Code
$container['activation'] = function ($c) {
	return new \Cartalyst\Sentinel\Activations\IlluminateActivationRepository;
};

# -----------------------------------------------------------------------------
# Action factories Controllers
# -----------------------------------------------------------------------------

/*
** Adding controllers to app container
*/

$container['ListController'] = function($c){
  return new \App\Controllers\ListController($c);
};

$container['ReservationController'] = function($c){
  return new \App\Controllers\ReservationController($c);
};

$container['ContributorController'] = function($c){
  return new \App\Controllers\ContributorController($c);
};

# -----------------------------------------------------------------------------
# Factories Models
# -----------------------------------------------------------------------------

$container['Model\User'] = function ($c) {
    return new App\Models\User;
};

$container['Model\Item'] = function ($c) {
    return new App\Models\Item;
};

$container['Model\Contributor'] = function ($c) {
    return new App\Models\Contributor;
};

$container['Model\Message'] = function ($c) {
    return new App\Models\Message;
};

# -----------------------------------------------------------------------------
# Factories Repositories
# -----------------------------------------------------------------------------

$container['App\Repositories\HomeRepository'] = function ($c) {
	return new App\Repositories\HomeRepository(
        $c->get('Model\User')
	);
};

$container['App\Repositories\UserRepository'] = function ($c) {
	return new App\Repositories\UserRepository(
        $c->get('Model\User')
	);
};

# -----------------------------------------------------------------------------
# Factories Services
# -----------------------------------------------------------------------------

$container['Mailer'] = function ($c) {
    return new App\Service\Mailer(
        $c->get('view')
    );
};