<?php

namespace admin\core\services\entree;

interface IEntreeService
{
    public function getEntrees(): array;
    public function getEntreeById(int $id): array;
//    public function getEntreeByServiceId(int $id_service): array;
//    public function getEntreeByDepartementId(int $id_departement): array;
    public function createEntree(array $data): int;
//    public function updateEntree(int $id, array $data): void;
//    public function deleteEntree(int $id): void;
}