<?php

namespace admin\core\services\departement;

interface IDepartementService
{
    public function getDepartements(): array;
    public function getDepartementById(int $id): array;
    public function createDepartement(array $data): int;
//    public function updateDepartement(int $id, array $data): void;
//    public function deleteDepartement(int $id): void;
    public function getServices(): array;
    public function getServiceById(int $id): array;
    public function createService(array $data): int;
//    public function updateService(int $id, array $data): void;
//    public function deleteService(int $id): void;
}