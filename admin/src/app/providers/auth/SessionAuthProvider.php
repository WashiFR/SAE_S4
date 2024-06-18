<?php

namespace admin\app\providers\auth;

use admin\core\services\auth\AuthService;
use admin\core\services\auth\AuthServiceBadDataException;
use admin\core\services\auth\IAuthService;

class SessionAuthProvider implements IAuthProvider
{
    private IAuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function register(string $email, string $password): void
    {
        $this->authService->register($email, $password);
    }

    public function signin(string $email, string $password): void
    {
        if (!$this->authService->byCredentials($email, $password)) {
            throw new AuthServiceBadDataException('Erreur 400 : Email ou mot de passe incorrect', 400);
        }

        $_SESSION['admin'] = $this->authService->getAdmin($email);
    }

    public function signout(): void
    {
        session_destroy();
    }

    public function isSignedIn(string $email): bool
    {
        return isset($_SESSION['admin']);
    }

    public function getSignedInUser(): array
    {
        return $_SESSION['admin'];
    }
}