<?php

namespace api\api\actions;

use api\api\actions\AbstractAction;
use api\core\services\departement\DepartementService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetSearchDepartementAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $chaine_carac = $request->getQueryParams();
        $chaine = isset($chaine_carac['q']) ? $chaine_carac['q'] : '';

        if (!empty($chaine)) {
            $departement_service = new DepartementService();
            $departements = $departement_service->getDepartementByCarac($chaine);
            $departements_result = [];

            foreach ($departements as $dep) {
                $departements_result[] = [
                    "departements" => [
                        "id" => $dep['id'],
                        "nom" => $dep['nom'],
                        "etage" => $dep['etage'],
                        "description" => $dep['description']
                    ],
                    "links" => [
                        "self" => [
                            "href" => "/departements/" . $dep['id']
                        ]
                    ]
                ];
            }
        }
        $data = ['type' => 'collection', 'count' => count($departements_result), 'departements' => $departements_result];
        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->withStatus(200);
    }
}