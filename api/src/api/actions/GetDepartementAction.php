<?php

namespace api\api\actions;

use api\api\actions\AbstractAction;
use api\core\services\departement\DepartementService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetDepartementAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $departements_service = new DepartementService();
        $sql = $departements_service->getDepartements();

        $departements = [];
        foreach ($sql as $dep) {
            $departements[] = [
                "département" => [
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

        $data = ['type' => 'collection', 'count' => count($departements), 'départements' => $departements];
        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}