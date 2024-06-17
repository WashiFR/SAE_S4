<?php

namespace admin\app\actions;

use admin\app\actions\AbstractAction;
use admin\core\services\departement\DepartementService;
use admin\core\services\departement\DepartementServiceNotFoundException;
use admin\core\services\departement\IDepartementService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

class CreateNewEntreeAction extends AbstractAction
{
    protected string $template = 'CreateNewEntreeView.twig';
    private IDepartementService $departementService;

    public function __construct()
    {
        $this->departementService = new DepartementService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $departements = $this->departementService->getDepartements();
            $services = $this->departementService->getServices();
        } catch (DepartementServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template, ['departements' => $departements, 'services' => $services]);
    }
}