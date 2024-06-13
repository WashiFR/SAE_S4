<?php

namespace api\core\services\entree;

use api\core\domain\Entree;
use api\core\services\entree\IEntreeService;

class EntreService implements IEntreeService
{
    public function getEntrees(): array
    {
        try {
            $sql = Entree::all();
        } catch (\Exception $e) {
            throw new EntreeServiceNotFoundException('Erreur 404 : Aucune entree trouvée', 404);
        }
        return $sql->toArray();
    }

    public function getEntreeById(int $id): array
    {
        try {
            $sql = Entree::all()->where('id', $id);
        } catch (\Exception $e) {
            throw new EntreeServiceNotFoundException('Erreur 404 : Aucune entree trouvée', 404);
        }
        return $sql->toArray();
    }
}