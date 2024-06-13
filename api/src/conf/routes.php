<?php
declare(strict_types=1);

use api\app\actions\ShowHomeAction;
use Slim\App;

return function(App $app): App {

    // ### Route de la page d'accueil ###
    $app->get('/', ShowHomeAction::class)->setName('home');

    return $app;

};