<?php

namespace admin\core\services\departement;

use admin\core\domain\Departement;
use admin\core\domain\Service;
use admin\core\services\departement\IDepartementService;

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
}