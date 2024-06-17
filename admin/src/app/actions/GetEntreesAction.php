<?php

namespace admin\app\actions;

use admin\app\actions\AbstractAction;
use admin\core\services\departement\DepartementService;
use admin\core\services\departement\DepartementServiceNotFoundException;
use admin\core\services\departement\IDepartementService;
use admin\core\services\entree\EntreeServiceNotFoundException;
use admin\core\services\entree\EntreService;
use admin\core\services\entree\IEntreeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

class GetEntreesAction extends AbstractAction
{
    protected string $template = 'GetEntreesView.twig';
    private IEntreeService $entreeService;
    private IDepartementService $departementService;

    public function __construct()
    {
        $this->entreeService = new EntreService();
        $this->departementService = new DepartementService();
    }
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $departement_id = $queryParams['departement'] ?? null;
        $service_id = $queryParams['service'] ?? null;

        try {
            if (!empty($departement_id) && !empty($service_id)) {
                $entrees = $this->entreeService->getEntreesByDepartementIdAndServiceId($departement_id, $service_id);
            } elseif (!empty($departement_id)) {
                $entrees = $this->entreeService->getEntreesByDepartementId($departement_id);
            } elseif (!empty($service_id)) {
                $entrees = $this->entreeService->getEntreesByServiceId($service_id);
            } else {
                $entrees = $this->entreeService->getEntrees();
            }

            $departements = $this->departementService->getDepartements();
            $services = $this->departementService->getServices();

            foreach ($entrees as $key => $entree) {
                $entrees[$key]['departement'] = $this->departementService->getDepartementsByEntreeId($entree['id']);
                $entrees[$key]['service'] = $this->departementService->getServicesByEntreeId($entree['id']);
            }

        } catch (EntreeServiceNotFoundException|DepartementServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, $this->template, [
            'entrees' => $entrees,
            'departements' => $departements,
            'services' => $services,
            'selectedDepartement' => $departement_id,
            'selectedService' => $service_id
        ]);
    }
}