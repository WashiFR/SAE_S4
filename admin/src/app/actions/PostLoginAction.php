<?php

namespace admin\app\actions;

use admin\app\actions\AbstractAction;
use admin\app\utils\CsrfException;
use admin\app\utils\CsrfService;
use admin\core\services\auth\AuthService;
use admin\core\services\auth\IAuthService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;

class PostLoginAction extends AbstractAction
{
    private IAuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody();

        try {
            CsrfService::check($data['csrf']);
        } catch (CsrfException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        }

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        $this->authService->login($email, $password);

        $routeContext = RouteContext::fromRequest($request);
        $url = $routeContext->getRouteParser()->urlFor('home');
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}