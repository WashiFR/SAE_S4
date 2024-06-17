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
                $sql = $service_service->getServicesByEntreeId($ent['id']);
                foreach ($sql as $service) {
                    $services[] = [
                        "NomDep" => $service['nom']
                    ];
                }
                $entrees_result[] = [
                    "entree" => [
                        "id" => $ent['id'],
                        "nom" => $ent['nom'],
                        "prenom" => $ent['prenom'],
                        "departement" => $services
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
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->withStatus(200);
    }
}