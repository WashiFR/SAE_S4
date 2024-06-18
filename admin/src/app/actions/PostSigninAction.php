<?php

namespace admin\app\actions;

use admin\app\providers\auth\IAuthProvider;
use admin\app\providers\auth\SessionAuthProvider;
use admin\app\utils\CsrfException;
use admin\app\utils\CsrfService;
use admin\core\services\auth\AuthServiceBadDataException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;

class PostSigninAction extends AbstractAction
{
    private IAuthProvider $authService;

    public function __construct()
    {
        $this->authService = new SessionAuthProvider();
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

        try {
            $this->authService->signin($email, $password);
        } catch (AuthServiceBadDataException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        }

        $routeContext = RouteContext::fromRequest($request);
        $url = $routeContext->getRouteParser()->urlFor('home');
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}