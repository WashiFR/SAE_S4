<?php

namespace admin\core\services\auth;

interface IAuthService
{
    public function login(string $email, string $password): void;
    public function signup(string $email, string $password): void;
    public function logout(): void;
}