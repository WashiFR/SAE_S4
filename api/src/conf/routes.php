<?php
declare(strict_types=1);

use Slim\App;

return function(App $app): App {

    // ### Routes pour l'api ###
    $app->get('/api/services', \api\api\actions\GetServicesAction::class)->setName('api.services');

    return $app;

};