<?php

namespace admin\app\actions;

use admin\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class CreateNewDepartementAction extends AbstractAction
{
    protected string $template = 'CreateNewDepartementView.twig';
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template);
    }
}