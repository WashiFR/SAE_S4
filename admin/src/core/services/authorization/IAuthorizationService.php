<?php

namespace admin\core\services\authorization;

interface IAuthorizationService
{
    public function isGranted(string $email, int $operation, string $ressource_id): bool;
}