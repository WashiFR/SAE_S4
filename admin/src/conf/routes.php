<?php
declare(strict_types=1);

use Slim\App;

return function(App $app): App {

    // ### Route de la page d'accueil ###
    $app->get('/', \admin\app\actions\ShowHomeAction::class)->setName('home');

    // ### Routes des Entree ###
    $app->get('/entrees', \admin\app\actions\GetEntreesAction::class)->setName('entrees');
    $app->get('/entrees/create', \admin\app\actions\CreateNewEntreeAction::class)->setName('entrees.create');
    $app->post('/entrees/create', \admin\app\actions\PostNewEntreeAction::class)->setName('entrees.create');

    return $app;

};