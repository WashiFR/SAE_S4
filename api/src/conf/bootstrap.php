<?php

use api\infrastructure\Eloquent;
use Slim\Factory\AppFactory;

session_start();

$app = AppFactory::create();
Eloquent::init(__DIR__ . '/conf.ini');

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);
//$app->setBasePath('/api/public');

$app=(require_once __DIR__ . '/routes.php')($app);

return $app;
