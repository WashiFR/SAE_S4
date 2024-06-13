<?php

use infrastructure\Eloquent;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

session_start();

$app = AppFactory::create();
Eloquent::init(__DIR__ . '/conf.ini');

// Twig
$twig = Twig::create(__DIR__ . '/../app/views', [
    'cache' => __DIR__ . '/cache',
    'auto_reload' => true
]);

//$twig->getEnvironment()->addGlobal('globals', [
//    'img_dir' => '../src/img/',
//]);

$app->add(TwigMiddleware::create($app, $twig));

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);
$app->setBasePath('/api/public');

$app=(require_once __DIR__ . '/routes.php')($app);

return $app;