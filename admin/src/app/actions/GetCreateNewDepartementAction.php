<?php

namespace admin\app\actions;

use admin\app\actions\AbstractAction;
use admin\app\utils\CsrfService;
use admin\core\services\authorization\AuthorizationService;
use admin\core\services\authorization\IAuthorizationService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

class GetCreateNewDepartementAction extends AbstractAction
{
    protected string $template = 'CreateNewDepartementView.twig';
    private IAuthorizationService $authorizationService;

    public function __construct()
    {
        $this->authorizationService = new AuthorizationService();
    }
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        if (!isset($_SESSION['admin'])) {
            $routeContext = RouteContext::fromRequest($request);
            $url = $routeContext->getRouteParser()->urlFor('signin');
            return $response->withStatus(302)->withHeader('Location', $url);
        } elseif (!$this->authorizationService->isGranted($_SESSION['admin']['email'], AuthorizationService::CREATE_DEPARTEMENT, '')) {
            throw new HttpUnauthorizedException($request, 'Vous n\'avez pas les droits pour accéder à cette page');
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template, ['csrf' => CsrfService::generate()]);
    }
}