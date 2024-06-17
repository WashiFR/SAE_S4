<?php

namespace admin\core\services\departement;

use admin\core\domain\entities\Departement;
use admin\core\domain\entities\Service;

class DepartementService implements IDepartementService
{

    public function getDepartements(): array
    {
        try {
            $sql = Departement::all();
        } catch (\Exception $e) {
            throw new DepartementServiceNotFoundException('Erreur 404 : Aucun département trouvé', 404);
        }
        return $sql->toArray();
    }

    public function getDepartementById(int $id): array
    {
        try {
            $sql = Departement::all()->where('id', $id);
        } catch (\Exception $e) {
            throw new DepartementServiceNotFoundException('Erreur 404 : Aucun département trouvé', 404);
        }
        return $sql->toArray();
    }

    public function getDepartementsByEntreeId(int $id): array
    {
        try {
            $sql = Departement::whereHas('entrees', function ($query) use ($id) {
                $query->where('id_entree', $id);
            })->get();
        } catch (\Exception $e) {
            throw new DepartementServiceNotFoundException('Erreur 404 : Aucun département trouvé', 404);
        }
        return $sql->toArray();
    }

    public function createDepartement(array $data): int
    {
        $departement = new Departement();
        $departement->nom = $data['nom'];
        $departement->etage = $data['etage'];
        $departement->description = $data['description'];
        $departement->save();
        return $departement->id;
    }

    public function getServices(): array
    {
        try {
            $sql = Service::all();
        } catch (\Exception $e) {
            throw new DepartementServiceNotFoundException('Erreur 404 : Aucun service trouvé', 404);
        }
        return $sql->toArray();
    }

    public function getServiceById(int $id): array
    {
        try {
            $sql = Service::all()->where('id', $id);
        } catch (\Exception $e) {
            throw new DepartementServiceNotFoundException('Erreur 404 : Aucun service trouvé', 404);
        }
        return $sql->toArray();
    }

    public function getServicesByEntreeId(int $id): array
    {
        try {
            $sql = Service::whereHas('entrees', function ($query) use ($id) {
                $query->where('id_entree', $id);
            })->get();
        } catch (\Exception $e) {
            throw new DepartementServiceNotFoundException('Erreur 404 : Aucun service trouvé', 404);
        }
        return $sql->toArray();
    }

    public function createService(array $data): int
    {
        $service = new Service();
        $service->nom = $data['nom'];
        $service->etage = $data['etage'];
        $service->description = $data['description'];
        $service->save();
        return $service->id;
    }
}