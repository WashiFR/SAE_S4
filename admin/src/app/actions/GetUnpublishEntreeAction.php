<?php

namespace admin\app\actions;

use admin\app\actions\AbstractAction;
use admin\core\services\entree\EntreService;
use admin\core\services\entree\IEntreeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class GetUnpublishEntreeAction extends AbstractAction
{
    private IEntreeService $entreeService;

    public function __construct()
    {
        $this->entreeService = new EntreService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $this->entreeService->unpublishEntree((int)$args['id']);

        $routeContext = RouteContext::fromRequest($request);
        $url = $routeContext->getRouteParser()->urlFor('entrees');
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}