<?php

namespace api\app\actions;

use api\app\actions\AbstractAction;
use api\core\services\entree\EntreeServiceNotFoundException;
use api\core\services\entree\EntreService;
use api\core\services\entree\IEntreeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

class GetEntreesAction extends AbstractAction
{
    protected string $template = 'GetEntreesView.twig';
    private IEntreeService $entreeService;

    public function __construct()
    {
        $this->entreeService = new EntreService();
    }
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $entrees = $this->entreeService->getEntrees();
        } catch (EntreeServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template, ['entrees' => $entrees]);
    }
}