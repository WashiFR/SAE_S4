<?php

namespace api\app\actions;

use api\app\actions\AbstractAction;
use api\core\services\entree\EntreService;
use api\core\services\entree\IEntreeService;
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
            'email' => $data['email']
        ]);

        $routeContext = RouteContext::fromRequest($request);
        $url = $routeContext->getRouteParser()->urlFor('home');
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}