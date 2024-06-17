<?php

namespace api\api\actions;

use api\api\actions\AbstractAction;
use api\core\services\departement\DepartementService;
use api\core\services\entree\EntreeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetSearchServiceAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $chaine_carac = $request->getQueryParams();
        $chaine = isset($chaine_carac['q']) ? $chaine_carac['q'] : '';

        if(!empty($chaine)){
            $service_service = new DepartementService();
            $services = $service_service->getServicesByCarac($chaine);
            $services_result = [];

            foreach ($services as $ser) {
                $services_result[] = [
                    "services" => [
                        "id" => $ser['id'],
                        "nom" => $ser['nom'],
                        "etage" => $ser['etage'],
                        "description" => $ser['description']
                    ],
                    "links" => [
                        "self" => [
                            "href" => "/services/" . $ser['id']
                        ]
                    ]
                ];
            }
        }
        $data = ['type' => 'collection', 'count' => count($services_result), 'services' => $services_result];
        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->withStatus(200);
    }
}