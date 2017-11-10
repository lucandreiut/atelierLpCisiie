<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

$app->add(
    function ($request, $response, $next) {
        $this->view->offsetSet('flash', $this->flash);
        return $next($request, $response);
    }
);

$app->add(new \App\Middlewares\ValidationErrorsMiddleware($container));
$app->add(new \App\Middlewares\OldInputDataMiddleware($container));