<?php

namespace api\api\actions;

use api\api\actions\AbstractAction;
use api\core\services\departement\DepartementService;
use api\core\services\entree\EntreeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetEntreeByDepartementAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $services_id = $args['id'];
        $entrees_query = new EntreeService();
        $service_service = new DepartementService();
        $entrees = $entrees_query->getEntreeByDepartmentID($services_id);

        if($entrees){
            $result_entrees = [];
            foreach ($entrees as $entree){
                $result_services = [];
                $departments = [];
                $sql_bis = $service_service->getServicesByEntreeId($entree['id']);
                foreach ($sql_bis as $service){
                    $result_services[] = [
                        "NomService" => $service['nom']
                    ];
                }
                $sql_dep = $service_service->getDepartementsByEntreeId($entree['id']);
                foreach ($sql_dep as $departement){
                    $departments[] = [
                        "NomDep" => $departement['nom']
                    ];
                }
                $result_entrees[] = [
                    "entree" => [
                        "id" => $entree['id'],
                        "nom" => $entree['nom'],
                        "prenom" => $entree['prenom'],
                        "services" => $result_services,
                        "departements" => $departments,
                        "image" => $entree['img']
                    ],
                    "links" => [
                        "self" => [
                            "href" => "/entrees/" . $entree['id']
                        ]
                    ]
                ];
            }
        }
        $data = ['type' => 'collection', 'count' => count($entrees), 'entrees' => $result_entrees];
        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}