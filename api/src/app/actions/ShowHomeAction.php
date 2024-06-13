<?php

namespace api\app\actions;

use api\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ShowHomeAction extends AbstractAction
{
    private string $template;

    public function __construct()
    {
        $this->template = 'HomeView.twig';
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template);
    }
}