<?php

namespace api\api\actions;

use api\api\actions\AbstractAction;
use api\core\services\departement\DepartementService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetServiceByIdAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $service_id = $args['id'];
        $service_service = new DepartementService();
        $service = $service_service->getServiceById($service_id);
        $info_service = [];

        if($service){
            foreach ($service as $ser){
                $info_service[] = [
                    "service" => [
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
        $data = ['type' => 'collection', 'count' => count($info_service), 'service' => $info_service];
        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->withStatus(200);
    }
}