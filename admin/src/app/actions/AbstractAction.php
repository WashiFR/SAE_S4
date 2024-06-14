<?php

namespace admin\app\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractAction
{
    protected string $template;
    abstract public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface;
}