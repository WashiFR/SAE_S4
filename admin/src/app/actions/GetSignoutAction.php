<?php

namespace admin\app\actions;

use admin\app\providers\auth\IAuthProvider;
use admin\app\providers\auth\SessionAuthProvider;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class GetSignoutAction extends AbstractAction
{
    private IAuthProvider $authService;

    public function __construct()
    {
        $this->authService = new SessionAuthProvider();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $this->authService->signout();

        $routeContext = RouteContext::fromRequest($request);
        $url = $routeContext->getRouteParser()->urlFor('signin');
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}