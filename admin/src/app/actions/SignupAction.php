<?php

namespace admin\app\actions;

use admin\app\actions\AbstractAction;
use admin\app\utils\CsrfService;
use admin\core\domain\entities\Admin;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Views\Twig;

class SignupAction extends AbstractAction
{
    protected string $template = 'SignupView.twig';
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== Admin::SUPER_ADMIN) {
            throw new HttpBadRequestException($request, 'Vous n\'avez pas les droits pour accéder à cette page');
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template, ['csrf' => CsrfService::generate()]);
    }
}