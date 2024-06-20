<?php

namespace admin\core\services\auth;

interface IAuthService
{
    public function register(string $email, string $password): string;
    public function byCredentials(string $email, string $password): bool;
    public function getAdmin(string $email): array;
}