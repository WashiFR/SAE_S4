<?php

namespace api\api\actions;

use api\api\actions\AbstractAction;
use api\core\services\departement\DepartementService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetDepartementByIdAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $depart_id = $args['id'];
        $depart_service = new DepartementService();
        $departement = $depart_service->getServiceById($depart_id);
        $info_departement = [];

        if($departement){
            foreach ($departement as $dep){
                $info_departement[] = [
                    "departement" => [
                        "id" => $dep['id'],
                        "nom" => $dep['nom'],
                        "etage" => $dep['etage'],
                        "description" => $dep['description']
                    ],
                    "links" => [
                        "self" => [
                            "href" => "/services/" . $dep['id']
                        ]
                    ]
                ];
            }
        }
        $data = ['type' => 'collection', 'count' => count($info_departement), 'departement' => $info_departement];
        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->withStatus(200);
    }
}