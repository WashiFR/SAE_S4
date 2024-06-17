<?php

namespace admin\app\actions;

use admin\app\actions\AbstractAction;
use admin\core\services\auth\AuthService;
use admin\core\services\auth\IAuthService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class LogoutAction extends AbstractAction
{
    private IAuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $this->authService->logout();

        $routeContext = RouteContext::fromRequest($request);
        $url = $routeContext->getRouteParser()->urlFor('login');
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}