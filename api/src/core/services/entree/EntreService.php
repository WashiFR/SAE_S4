<?php

namespace api\core\services\entree;

use api\core\domain\Entree;
use api\core\services\entree\IEntreeService;

class EntreService implements IEntreeService
{
    public function getEntrees(): array
    {
        try {
            $sql = Entree::select('id', 'nom', 'prenom', 'fonction', 'num_bureau', 'num_fixe', 'num_mobile', 'email')
                ->orderBy('nom', 'asc')
                ->get();
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

    public function createEntree(array $data): int
    {
        $entree = new Entree();
        $entree->nom = $data['nom'];
        $entree->prenom = $data['prenom'];
        $entree->fonction = $data['fonction'];
        $entree->num_bureau = $data['num_bureau'];
        $entree->num_fixe = $data['num_fixe'];
        $entree->num_mobile = $data['num_mobile'];
        $entree->email = $data['email'];
        $entree->save();
        return $entree->id;
    }
}