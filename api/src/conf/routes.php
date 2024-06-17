<?php
declare(strict_types=1);

use Slim\App;

return function(App $app): App {

    // ### Routes pour l'api ###
    $app->get('/api/services', \api\api\actions\GetServicesAction::class)->setName('api.services');
    $app->get('/api/entrees', \api\api\actions\GetEntreesActions::class)->setName('api.entrees');
    $app->get('/api/entrees/search', \api\api\actions\GetSearchEntreeAction::class)->setName('api.searchEntree');
    $app->get('/api/departements', \api\api\actions\GetDepartementAction::class)->setName('api.departements');
    $app->get('/api/services/{id}/entrees', \api\api\actions\GetEntreesByServiceAction::class)->setName('api.entreesByService');
    $app->get('/api/entrees/{id}', \api\api\actions\GetEntreeByIdAction::class)->setName('api.entreesById');
    return $app;

};