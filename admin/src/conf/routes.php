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

    // ### Routes des Services ###
    $app->get('/services/create', \admin\app\actions\CreateNewServiceAction::class)->setName('services.create');
    $app->post('/services/create', \admin\app\actions\PostNewServiceAction::class)->setName('services.create');

    // ### Routes des Départements ###
    $app->get('/departements/create', \admin\app\actions\CreateNewDepartementAction::class)->setName('departements.create');
    $app->post('/departements/create', \admin\app\actions\PostNewDepartementAction::class)->setName('departements.create');

    // ### Routes de Connexion ###
    $app->get('/login', \admin\app\actions\LoginAction::class)->setName('login');
    $app->post('/login', \admin\app\actions\PostLoginAction::class)->setName('login');
    $app->get('/signup', \admin\app\actions\SignupAction::class)->setName('signup');
    $app->post('/signup', \admin\app\actions\PostSignupAction::class)->setName('signup');
    $app->get('/logout', \admin\app\actions\LogoutAction::class)->setName('logout');

    return $app;

};