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
            })->get();
            $sql = $sql->sortBy('nom');
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
            })->get();
            $sql = $sql->sortBy('nom');
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
            })->get();
            $sql = $sql->sortBy('nom');
        } catch (\Exception $e) {
            throw new EntreeServiceNotFoundException('Erreur 404 : Aucune entree trouvée', 404);
        }
        return $sql->toArray();
    }

    public function createEntree(array $data, array $dep_id, array $serv_id): int
    {
        $entree = new Entree();
        $entree->img = $data['img'];
        $entree->nom = $data['nom'];
        $entree->prenom = $data['prenom'];
        $entree->fonction = $data['fonction'];
        $entree->num_bureau = $data['num_bureau'];
        $entree->num_fixe = $data['num_fixe'];
        $entree->num_mobile = $data['num_mobile'];
        $entree->email = $data['email'];
        $entree->save();
        foreach ($dep_id as $id) {
            $entree->departements()->attach($id);
        }
        foreach ($serv_id as $id) {
            $entree->services()->attach($id);
        }
        return $entree->id;
    }
}