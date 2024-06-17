<?php

namespace admin\core\services\auth;

use admin\core\domain\entities\Admin;

class AuthService implements IAuthService
{

    public function login(string $email, string $password): void
    {
        if (empty($email) || empty($password)) {
            throw new AuthServiceBadDataException('Erreur 400 : Données manquantes', 400);
        }

        try {
            $sql = Admin::all()->where('email', $email)->first();
        } catch (\Exception $e) {
            throw new AuthServiceNotFoundException('Erreur 404 : Aucun utilisateur trouvé', 404);
        }

        if (password_verify($password, $sql->password)) {
            $_SESSION['user_id'] = $sql->id;
            $_SESSION['user_role'] = $sql->role;
        } else {
            throw new AuthServiceBadDataException('Erreur 400 : Mauvais mot de passe', 400);
        }
    }

    public function signup(string $email, string $password): void
    {
        $sql = Admin::all()->where('email', $email)->first();

        if ($sql) {
            throw new AuthServiceBadDataException('Erreur 400 : Email déjà existant', 400);
        }

        if (empty($email) || empty($password)) {
            throw new AuthServiceBadDataException('Erreur 400 : Données manquantes', 400);
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new AuthServiceBadDataException('Erreur 400 : Email invalide', 400);
        } elseif (strlen($password) < 8) {
            throw new AuthServiceBadDataException('Erreur 400 : Mot de passe trop court', 400);
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $user = new Admin();
        $user->email = $email;
        $user->password = $passwordHash;
        $user->role = Admin::ADMIN;
        $user->save();

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_role'] = $user->role;
    }

    public function logout(): void
    {
        session_destroy();
    }
}