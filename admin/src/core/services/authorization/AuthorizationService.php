<?php

namespace admin\core\services\authorization;

use admin\core\domain\entities\Admin;
use admin\core\services\authorization\IAuthorizationService;

class AuthorizationService implements IAuthorizationService
{
    const CREATE_ENTREE = 1;
    const CREATE_DEPARTEMENT = 2;
    const CREATE_SERVICE = 3;
    const CREATE_ADMIN = 4;

    public function isGranted(string $email, int $operation, string $ressource_id): bool
    {
        switch ($operation) {
            case $this::CREATE_ENTREE:
            case $this::CREATE_DEPARTEMENT:
            case $this::CREATE_SERVICE:
                return $this->isAdmin($email) || $this->isSuperAdmin($email);
            case $this::CREATE_ADMIN:
                return $this->isSuperAdmin($email);
            default:
                return false;
        }
    }

    private function isAdmin(string $email): bool
    {
        return Admin::where('email', $email)->first()->role == Admin::ADMIN;
    }

    private function isSuperAdmin(string $email): bool
    {
        return Admin::where('email', $email)->first()->role == Admin::SUPER_ADMIN;
    }
}