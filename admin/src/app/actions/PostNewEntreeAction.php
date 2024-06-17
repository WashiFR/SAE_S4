<?php

namespace admin\app\actions;

use admin\app\actions\AbstractAction;
use admin\core\services\entree\EntreService;
use admin\core\services\entree\IEntreeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class PostNewEntreeAction extends AbstractAction
{
    protected string $template = '';
    private IEntreeService $entreeService;

    public function __construct()
    {
        $this->entreeService = new EntreService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody();

        $entree_id = $this->entreeService->createEntree([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'fonction' => $data['fonction'],
            'num_bureau' => $data['num_bureau'],
            'num_fixe' => $data['num_fixe'] ?? null,
            'num_mobile' => $data['num_mobile'],
            'email' => $data['email'],
            'departement_id' => $data['departement_id'],
            'service_id' => $data['service_id']
        ]);

        $routeContext = RouteContext::fromRequest($request);
        $url = $routeContext->getRouteParser()->urlFor('home');
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}