<?php

use admin\infrastructure\Eloquent;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

session_start();

$app = AppFactory::create();
Eloquent::init(__DIR__ . '/conf.ini');

// Twig
$twig = Twig::create(__DIR__ . '/../app/views', ['cache' => false]);

$twig->getEnvironment()->addGlobal('globals', [
    'user_id' => $_SESSION['user_id'] ?? null,
    'user_role' => $_SESSION['user_role'] ?? null,
    'admin' => \admin\core\domain\entities\Admin::ADMIN,
    'super_admin' => \admin\core\domain\entities\Admin::SUPER_ADMIN
]);

$app->add(TwigMiddleware::create($app, $twig));

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

$app=(require_once __DIR__ . '/routes.php')($app);

return $app;