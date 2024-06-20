<?php

namespace admin\core\services\auth;

use admin\core\domain\entities\Admin;

class AuthService implements IAuthService
{

    public function register(string $email, string $password): string
    {
        $sql = Admin::all()->where('email', $email)->first();

        if ($sql) {
            throw new AuthServiceBadDataException('Erreur 400 : Email déjà existant', 400);
        }

        $admin = new Admin();
        $admin->email = $email;
        $admin->password = password_hash($password, PASSWORD_DEFAULT);
        $admin->role = Admin::ADMIN;
        $admin->save();
        return $admin->id;
    }

    public function byCredentials(string $email, string $password): bool
    {
        $admin = Admin::all()->where('email', $email)->first();

        if ($admin) {
            return password_verify($password, $admin->password);
        } else {
            return false;
        }
    }

    public function getAdmin(string $email): array
    {
        try {
            $admin = Admin::all()->where('email', $email)->first();
        } catch (\Exception $e) {
            throw new AuthServiceBadDataException('Erreur 400 : Email non existant', 400);
        }

        return $admin->toArray();
    }
}