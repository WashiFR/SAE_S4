<?php

namespace api\core\services\departement;

use api\core\domain\Departement;
use api\core\domain\Entree;
use api\core\domain\Service;
use api\core\services\departement\IDepartementService;

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


    public function getDepartementByCarac(string $carac){
        try{
            $sql = Departement::where('nom', 'LIKE', "%{$carac}%")->get();
        }catch (\Exception $e) {
            throw new DepartementServiceNotFoundException('Erreur 404 : Aucun service trouvé', 404);
        }
        return $sql->toArray();

    }

    public function getDepartementsByEntreeId(int $id): array
    {
        try{
            $entree = Entree::find($id);
            $sql = $entree->departements;
        }catch (\Exception $e) {
            throw new DepartementServiceNotFoundException('Erreur 404 : Aucun service trouvé', 404);
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

    public function getServicesByEntreeId(int $id): array
    {
        try{
            $entree = Entree::find($id);
            $sql = $entree->services;
        }catch (\Exception $e) {
            throw new DepartementServiceNotFoundException('Erreur 404 : Aucun service trouvé', 404);
        }
        return $sql->toArray();
    }

    public function getServicesByCarac(string $carac){
        try{
            $sql = Service::where('nom', 'LIKE', "%{$carac}%")->get();
        }catch (\Exception $e) {
            throw new DepartementServiceNotFoundException('Erreur 404 : Aucun service trouvé', 404);
        }
        return $sql->toArray();

    }


}