<?php
declare(strict_types=1);

use Slim\App;

return function(App $app): App {

    // ### Route de la page d'accueil ###
    $app->get('/', \api\app\actions\ShowHomeAction::class)->setName('home');

    // ### Routes des Entree ###
    $app->get('/entrees/create', \api\app\actions\CreateNewEntreeAction::class)->setName('entrees.create');
    $app->post('/entrees/create', \api\app\actions\PostNewEntreeAction::class)->setName('entrees.create');

    return $app;

};