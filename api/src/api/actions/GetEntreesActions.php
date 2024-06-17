<?php

namespace api\api\actions;

use api\api\actions\AbstractAction;
use api\core\domain\Entree;
use api\core\services\departement\DepartementService;
use api\core\services\entree\EntreeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetEntreesActions extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $query = $request->getQueryParams();
        $entree_service = new EntreeService();
        $service_service = new DepartementService();

        if(isset($query['sort']) && $query['sort'] === 'nom-asc'){
            $sql = $entree_service->getEntreesByAsc();
        }else if(isset($query['sort']) && $query['sort'] === 'nom-desc'){
            $sql = $entree_service->getEntreesByDesc();
        }else{
            $sql = $entree_service->getEntrees();
        }
        $entrees = [];
        foreach ($sql as $ent) {
            $services = [];
            $sql_bis = $service_service->getServicesByEntreeId($ent['id']);
            foreach ($sql_bis as $service){
                $services[] = [
                    "Nom du département" => $service['nom']
                    ];
            }
            $entrees[] = [
                "entree" => [
                    "id" => $ent['id'],
                    "nom" => $ent['nom'],
                    "prenom" => $ent['prenom'],
                    "departement" => $services
                ],
                "links" => [
                    "self" => [
                        "href" => "/entree/" . $ent['id']
                    ]
                ]
            ];
        }

        $data = ['type' => 'collection', 'count' => count($entrees), 'entrees' => $entrees];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}