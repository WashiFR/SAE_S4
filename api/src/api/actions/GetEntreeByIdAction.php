<?php

namespace api\api\actions;

use api\api\actions\AbstractAction;
use api\core\services\departement\DepartementService;
use api\core\services\entree\EntreeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetEntreeByIdAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $entree_id = $args['id'];
        $entree_service = new EntreeService();
        $service_service = new DepartementService();
        $sql = $entree_service->getEntreeById($entree_id);
        $services = [];
        $departments = [];
        if($sql){
            foreach($sql as $e){
                $sql_bis = $service_service->getServicesByEntreeId($e['id']);
                foreach ($sql_bis as $service){
                    $services[] = [
                        "Nomservice" => $service['nom']
                    ];
                }
                $sql_dep = $service_service->getDepartementsByEntreeId($e['id']);
                foreach ($sql_dep as $departement){
                    $departments[] = [
                        "NomDep" => $departement['nom']
                    ];
                }
                $result_entree[] = [
                    "entree" => [
                        "id" => $e['id'],
                        "nom" => $e['nom'],
                        "prenom" => $e['prenom'],
                        "fonction" => $e['fonction'],
                        "Numéro de bureau" => $e['num_bureau'],
                        "Numéro de téléphone fixe" => $e['num_fixe'],
                        "Numéro de téléphone mobile" => $e['num_mobile'],
                        "Email" => $e['email'],
                        "services" => $services,
                        "departement" => $departments
                    ],
                    "links" => [
                        "self" => [
                            "href" => "/entrees/" . $e['id']
                        ]
                    ]
                ];
            }
            }

        $data = ['type' => 'collection', 'count' => count($result_entree), 'entrees' => $result_entree];
        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->withStatus(200);
    }
}