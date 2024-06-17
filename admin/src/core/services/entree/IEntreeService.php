<?php

namespace admin\core\services\entree;

interface IEntreeService
{
    public function getEntrees(): array;
    public function getEntreeById(int $id): array;
    public function getEntreesByServiceId(int $id_service): array;
    public function getEntreesByDepartementId(int $id_departement): array;
    public function getEntreesByDepartementIdAndServiceId(int $id_departement, int $id_service): array;
    public function createEntree(array $data): int;
//    public function updateEntree(int $id, array $data): void;
//    public function deleteEntree(int $id): void;
}