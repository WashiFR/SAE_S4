<?php

namespace admin\app\actions;

use admin\app\actions\AbstractAction;
use admin\app\utils\CsrfService;
use admin\core\services\authorization\AuthorizationService;
use admin\core\services\authorization\IAuthorizationService;
use admin\core\services\departement\DepartementService;
use admin\core\services\departement\DepartementServiceNotFoundException;
use admin\core\services\departement\IDepartementService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

class GetCreateNewEntreeAction extends AbstractAction
{
    protected string $template = 'CreateNewEntreeView.twig';
    private IDepartementService $departementService;
    private IAuthorizationService $authorizationService;

    public function __construct()
    {
        $this->departementService = new DepartementService();
        $this->authorizationService = new AuthorizationService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        if (!isset($_SESSION['admin'])) {
            $routeContext = RouteContext::fromRequest($request);
            $url = $routeContext->getRouteParser()->urlFor('signin');
            return $response->withStatus(302)->withHeader('Location', $url);
        } elseif (!$this->authorizationService->isGranted($_SESSION['admin']['email'], AuthorizationService::CREATE_ENTREE, '')) {
            throw new HttpUnauthorizedException($request, 'Vous n\'avez pas les droits pour accéder à cette page');
        }

        try {
            $departements = $this->departementService->getDepartements();
            $services = $this->departementService->getServices();
        } catch (DepartementServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template, [
            'departements' => $departements,
            'services' => $services,
            'csrf' => CsrfService::generate()
        ]);
    }
}