<?php

namespace admin\app\actions;

use admin\app\actions\AbstractAction;
use admin\core\services\entree\EntreService;
use admin\core\services\entree\IEntreeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class CreateNewEntreeAction extends AbstractAction
{
    protected string $template = 'CreateNewEntreeView.twig';

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template);
    }
}