<?php

namespace admin\app\actions;

use admin\app\actions\AbstractAction;
use admin\app\utils\CsrfService;
use admin\core\domain\entities\Admin;
use admin\core\services\departement\DepartementService;
use admin\core\services\departement\DepartementServiceNotFoundException;
use admin\core\services\departement\IDepartementService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

class CreateNewEntreeAction extends AbstractAction
{
    protected string $template = 'CreateNewEntreeView.twig';
    private IDepartementService $departementService;

    public function __construct()
    {
        $this->departementService = new DepartementService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        if (!isset($_SESSION['user_role'])) {
            $routeContext = RouteContext::fromRequest($request);
            $url = $routeContext->getRouteParser()->urlFor('login');
            return $response->withStatus(302)->withHeader('Location', $url);
        } elseif ($_SESSION['user_role'] !== Admin::ADMIN && $_SESSION['user_role'] !== Admin::SUPER_ADMIN) {
            throw new HttpBadRequestException($request, 'Vous n\'avez pas les droits pour accéder à cette page');
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