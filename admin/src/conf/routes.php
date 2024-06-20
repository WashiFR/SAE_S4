<?php
declare(strict_types=1);

use Slim\App;

return function(App $app): App {

    // ### Route de la page d'accueil ###
    $app->get('/', \admin\app\actions\GetShowHomeAction::class)->setName('home');

    // ### Routes des Entree ###
    $app->get('/entrees', \admin\app\actions\GetEntreesAction::class)->setName('entrees');
    $app->get('/entrees/create', \admin\app\actions\GetCreateNewEntreeAction::class)->setName('entrees.create');
    $app->post('/entrees/create', \admin\app\actions\PostNewEntreeAction::class)->setName('entrees.create');

    // ### Routes des Services ###
    $app->get('/services/create', \admin\app\actions\GetCreateNewServiceAction::class)->setName('services.create');
    $app->post('/services/create', \admin\app\actions\PostNewServiceAction::class)->setName('services.create');

    // ### Routes des Départements ###
    $app->get('/departements/create', \admin\app\actions\GetCreateNewDepartementAction::class)->setName('departements.create');
    $app->post('/departements/create', \admin\app\actions\PostNewDepartementAction::class)->setName('departements.create');

    // ### Routes de Connexion ###
    $app->get('/signin', \admin\app\actions\GetSigninAction::class)->setName('signin');
    $app->post('/signin', \admin\app\actions\PostSigninAction::class)->setName('signin');
    $app->get('/register', \admin\app\actions\GetRegisterAction::class)->setName('register');
    $app->post('/register', \admin\app\actions\PostRegisterAction::class)->setName('register');
    $app->get('/signout', \admin\app\actions\GetSignoutAction::class)->setName('signout');

    return $app;

};