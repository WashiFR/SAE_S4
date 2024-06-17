<?php

namespace admin\core\services\entree;

use admin\core\domain\entities\Entree;

class EntreService implements IEntreeService
{
    public function getEntrees(): array
    {
        try {
            $sql = Entree::all()->sortBy('nom');
        } catch (\Exception $e) {
            var_dump($e->getMessage());
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

    public function getEntreesByDepartementId(int $departement_id): array
    {
        try {
            $sql = Entree::whereHas('departements', function ($query) use ($departement_id) {
                $query->where('id_departement', $departement_id);
            })->sortBy('nom')->get();
        } catch (\Exception $e) {
            throw new EntreeServiceNotFoundException('Erreur 404 : Aucune entree trouvée', 404);
        }
        return $sql->toArray();
    }

    public function getEntreesByServiceId(int $service_id): array
    {
        try {
            $sql = Entree::whereHas('services', function ($query) use ($service_id) {
                $query->where('id_service', $service_id);
            })->sortBy('nom')->get();
        } catch (\Exception $e) {
            throw new EntreeServiceNotFoundException('Erreur 404 : Aucune entree trouvée', 404);
        }
        return $sql->toArray();
    }

    public function getEntreesByDepartementIdAndServiceId(int $departement_id, int $service_id): array
    {
        try {
            $sql = Entree::whereHas('departements', function ($query) use ($departement_id) {
                $query->where('id_departement', $departement_id);
            })->whereHas('services', function ($query) use ($service_id) {
                $query->where('id_service', $service_id);
            })->sortBy('nom')->get();
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
        $entree->departements()->attach($data['departement_id']);
        $entree->services()->attach($data['service_id']);
        return $entree->id;
    }
}