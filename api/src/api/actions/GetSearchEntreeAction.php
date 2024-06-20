<?php

namespace api\api\actions;

use api\api\actions\AbstractAction;
use api\core\services\departement\DepartementService;
use api\core\services\entree\EntreeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetSearchEntreeAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $chaine_carac = $request->getQueryParams();
        $chaine = isset($chaine_carac['q']) ? $chaine_carac['q'] : '';

        if(!empty($chaine)){
            $entreeService = new EntreeService();
            $service_service = new DepartementService();
            $entrees = $entreeService->getEntreeByCarac($chaine);
            $entrees_result = [];

            foreach ($entrees as $ent) {
                $services = [];
                $departments = [];
                $sql = $service_service->getServicesByEntreeId($ent['id']);
                foreach ($sql as $service) {
                    $services[] = [
                        "NomService" => $service['nom']
                    ];
                }
                $sql_dep = $service_service->getDepartementsByEntreeId($ent['id']);
                foreach ($sql_dep as $departement){
                    $departments[] = [
                        "NomDep" => $departement['nom']
                    ];
                }
                $entrees_result[] = [
                    "entree" => [
                        "id" => $ent['id'],
                        "nom" => $ent['nom'],
                        "prenom" => $ent['prenom'],
                        "departements" => $departments,
                        "services" => $services,
                        "image" => $ent['img']
                    ],
                    "links" => [
                        "self" => [
                            "href" => "/entrees/" . $ent['id']
                        ]
                    ]
                ];
            }
        }
        $data = ['type' => 'collection', 'count' => count($entrees_result), 'entrees' => $entrees_result];
        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}