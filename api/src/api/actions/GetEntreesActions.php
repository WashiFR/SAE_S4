<?php

namespace api\api\actions;

use api\api\actions\AbstractAction;
use api\core\domain\Entree;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetEntreesActions extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $sql = Entree::select('id', 'nom','prenom','fonction','num_bureau','num_fixe','num_mobile', 'email')->get();

        $entrees = [];
        foreach ($sql as $ent) {
            $entrees[] = [
                "services" => [
                    "id" => $ent->id,
                    "nom" => $ent->nom,
                    "prenom" => $ent->prenom,
                    "fonction" => $ent->fonction,
                    "Numéro de bureau" => $ent->num_bureau,
                    "Numéro de téléphone fixe" => $ent->num_fixe,
                    ""
                ],
                "links" => [
                    "self" => [
                        "href" => "/services/" . $ent->id . "/"
                    ]
                ]
            ];
        }

        $data = ['type' => 'collection', 'count' => count($entrees), 'services' => $entrees];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}