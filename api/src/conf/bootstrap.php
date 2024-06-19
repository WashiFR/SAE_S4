<?php

use api\infrastructure\Eloquent;
use Slim\Factory\AppFactory;

session_start();

$app = AppFactory::create();
Eloquent::init(__DIR__ . '/conf.ini');

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);
//$app->setBasePath('/api/public');


$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

//CORS
$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});


$app=(require_once __DIR__ . '/routes.php')($app);

return $app;
