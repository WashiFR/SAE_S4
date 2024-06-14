<?php

namespace admin\app\actions;

use admin\app\actions\AbstractAction;
use admin\core\services\departement\DepartementService;
use admin\core\services\departement\IDepartementService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class PostNewDepartementAction extends AbstractAction
{
    protected string $template = '';
    private IDepartementService $departementService;

    public function __construct()
    {
        $this->departementService = new DepartementService();
    }
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody();

        $departement_id = $this->departementService->createDepartement([
            'nom' => $data['nom'],
            'etage' => $data['etage'],
            'description' => $data['description']
        ]);

        $routeContext = RouteContext::fromRequest($request);
        $url = $routeContext->getRouteParser()->urlFor('home');
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}