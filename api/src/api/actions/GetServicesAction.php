<?php

namespace api\api\actions;

use api\api\actions\AbstractAction;
use api\core\domain\Service;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetServicesAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $sql = Service::select('id', 'nom','etage', 'description')->get();

        $services = [];
        foreach ($sql as $ser) {
            $services[] = [
                "services" => [
                    "id" => $ser->id,
                    "nom" => $ser->nom,
                    "etage" => $ser->etage,
                    "description" => $ser->description
                ],
                "links" => [
                    "self" => [
                        "href" => "/services/" . $ser->id . "/"
                    ]
                ]
            ];
        }

        $data = ['type' => 'collection', 'count' => count($services), 'services' => $services];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}